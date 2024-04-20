<?php

namespace App\Http\Controllers\CostumerPage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Models\Product;
use App\Models\Cart;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    public function index(): View
    {
        $data = DB::table('carts')
            ->join('products', 'carts.product_id', '=', 'products.id')
            ->select('carts.*', 'products.nama', 'products.kode', 'products.foto')
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                        ->from('transaction_lines')
                        ->whereColumn('carts.id', '!=', 'transaction_lines.cart_id');
            })
            ->get();

        return view('pages.customer-page.cart.index', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'user_id' => 'required|exists:users,id',
            'waktu_sewa' => 'required|date',
            'paket_sewa' => 'required|numeric',
            'status_ambil' => 'required|string',
            'sub_total' => 'required|numeric',
            'alamat' => 'nullable|string'
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($product->stok < 1) {
            return redirect()->back()->with('error', 'Stok produk tidak mencukupi');
        }

        $cart = Cart::where('product_id', $product->id)->first();
        $waktu_pengembalian = date('Y-m-d', strtotime($request->waktu_sewa . ' + ' . $request->paket_sewa . ' days'));

        DB::beginTransaction();
        try {
            $cart = new Cart();
            $cart->product_id = $product->id;
            $cart->user_id = $request->user_id;
            $cart->waktu_sewa = $request->waktu_sewa;
            $cart->paket_sewa = $request->paket_sewa;
            $cart->waktu_pengembalian = $waktu_pengembalian;
            $cart->status_ambil = $request->status_ambil;
            $cart->sub_total = $request->sub_total;
            $cart->alamat = $request->alamat;
            $cart->save();

            $product = Product::findOrFail($request->product_id);
            $product->stok = $product->stok - 1;
            $product->save();

            if ($request->alamat) {
                $user = User::findOrFail($request->user_id);
                $user->alamat = $request->alamat;
                $user->save();
            }

            DB::commit();
            return redirect()->route('cart.index')->with('success', 'Data berhasil ditambahkan ke keranjang');
        } catch (\Exception $th) {
            DB::rollBack();
            Log::error($th);
            return redirect()->back()->with('error', 'Data gagal ditambahkan ke keranjang');
        }
    }
}
