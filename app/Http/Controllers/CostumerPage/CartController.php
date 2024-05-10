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
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index(): View
    {
        $data = DB::table('carts')
            ->join('products', 'carts.product_id', '=', 'products.id')
            ->leftJoin('transaction_lines', 'carts.id', '=', 'transaction_lines.cart_id')
            ->whereNull('transaction_lines.cart_id')
            ->where('carts.user_id', '=', Auth::user()->id)
            ->select('carts.*', 'products.nama', 'products.kode', 'products.foto', 'products.id as productId')
            ->get();

        return view('pages.customer-page.cart.index', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate(
            [
            'product_id' => 'required|exists:products,id',
            'user_id' => 'required|exists:users,id',
            'waktu_sewa' => 'required|date',
            'paket_sewa' => 'required|numeric',
            'status_ambil' => 'required|string',
            'sub_total' => 'required|numeric',
            'alamat' => 'nullable|string'
            ],
            [
                'product_id.required' => 'Produk wajib diisi',
                'product_id.exists' => 'Produk tidak ditemukan',
                'user_id.exists' => 'Anda harus login terlebih dahulu',
                'user_id.required' => 'User wajib diisi',
                'waktu_sewa.required' => 'Waktu sewa wajib diisi',
                'waktu_sewa.date' => 'Waktu sewa harus berupa tanggal',
                'paket_sewa.required' => 'Paket sewa wajib diisi',
                'paket_sewa.numeric' => 'Paket sewa harus berupa angka',
                'status_ambil.required' => 'Status pengambilan wajib diisi',
                'status_ambil.string' => 'Status pengambilan harus berupa string',
                'sub_total.required' => 'Sub total wajib diisi',
                'sub_total.numeric' => 'Sub total harus berupa angka',
                'alamat.string' => 'Alamat harus berupa string'
            ]
        );

        $product = Product::findOrFail($request->product_id);

        if ($product->stok < 1) {
            return response()->json([
                'message' => 'Stok produk tidak mencukupi'
            ], 400);
        }

        if (auth()->user()->role_id != '3') {
            return response()->json([
                'message' => 'Anda tidak bisa menyewa produk'
            ], 400);
        }

        $cart = Cart::where('product_id', $product->id)->first();
        $waktu_pengembalian = date('Y-m-d', strtotime($request->waktu_sewa . ' + ' . $request->paket_sewa . ' days'));

        if ($request->status_ambil === 'antar' && $request->alamat === null) {
            return response()->json([
                'message' => 'Alamat pengambilan wajib diisi'
            ], 400);
        }


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

            if ($request->alamat) {
                $user = User::findOrFail($request->user_id);
                $user->alamat = $request->alamat;
                $user->save();
            }

            DB::commit();
            // return redirect()->route('cart.index')->with('success', 'Data berhasil ditambahkan ke keranjang');
            return response()->json([
                'message' => 'Data berhasil ditambahkan ke keranjang'
            ], 200);
        } catch (\Exception $th) {
            DB::rollBack();
            Log::error($th);
            return response()->json([
                'message' => 'Data gagal ditambahkan ke keranjang'
            ], 500);
        }
    }
}
