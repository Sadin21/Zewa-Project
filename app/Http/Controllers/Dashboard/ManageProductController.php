<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
use Nette\Utils\Random;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class ManageProductController extends Controller
{
    public function index(): View
    {
        return view('pages.dashboard.manage-product.index');
    }

    public function getAllData(Request $request): JsonResponse
    {
        $limit = $request->limit;
        $logedUserId = $request->query('logedUserId');

        $products = DB::table('products')
                    ->join('product_categories', 'products.category_id', '=', 'product_categories.id')
                    ->join('users', 'products.pemilik_id', '=', 'users.id')
                    ->where('products.pemilik_id', $logedUserId)
                    ->select('products.id', 'product_categories.nama as category', 'products.kode', 'users.nama as pemilik', 'products.nama', 'products.harga', 'products.tersewakan', 'products.stok', 'products.foto', 'products.deskripsi', 'products.created_at', 'products.updated_at');

        if ($limit && is_numeric($limit)) $products->limit($limit);

        return response()->json([
            'total' => $products->count(),
            'data' => $products->get(),
            'message' => 'Success get all data products'
        ], 200);
    }

    public function create(Request $request): mixed
    {
        $mode = 'create';
        $categories = ProductCategory::get();

        if ($request->getMethod() === 'GET') {
            return view('pages.dashboard.manage-product.create', compact('mode', 'categories'));
        }

        $input = $this->validate($request, [
            'category_id' => 'required|numeric',
            'pemilik_id' => 'required|numeric',
            'kode' => 'required|string',
            'nama' => 'required|string',
            'harga' => 'required|numeric',
            'deskripsi' => 'nullable|string',
            'stok' => 'nullable|numeric',
            'foto' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ], [
            'category_id.required' => 'Kategori produk wajib diisi',
            'category_id.numeric' => 'Kategori produk harus berupa angka',
            'pemilik_id.required' => 'Pemilik produk wajib diisi',
            'pemilik_id.numeric' => 'Pemilik produk harus berupa angka',
            'kode.required' => 'Kode produk wajib diisi',
            'kode.string' => 'Kode produk harus berupa string',
            'nama.required' => 'Nama produk wajib diisi',
            'nama.string' => 'Nama produk harus berupa string',
            'harga.required' => 'Harga produk wajib diisi',
            'harga.numeric' => 'Harga produk harus berupa angka',
            'deskripsi.string' => 'Deskripsi produk harus berupa string',
            'stok.numeric' => 'Stok produk harus berupa angka',
            'foto.image' => 'Foto produk harus berupa gambar',
            'foto.mimes' => 'Foto produk harus berupa gambar dengan format jpeg, png, jpg, gif, atau svg',
            'foto.max' => 'Foto produk tidak boleh lebih dari 2MB'
        ]);

        $input['tersewakan'] = 0;

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = Random::generate(10) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/imgs/product'), $filename);
            $input['foto'] = $filename;
        }

        try{
            Product::create($input);
            return redirect()->route('dashboard.manage-product.index')->with('success', 'Produk berhasil diubah');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', 'Produk gagal dibuat');
        }
    }

    public function update(Request $request, string $id): mixed
    {
        $mode = 'update';
        $categories = ProductCategory::get();
        $product = Product::find($id);

        if (!$product) return redirect()->route('dashboard.manage-product.index')->with('error', 'Produk tidak ditemukan');

        if ($request->getMethod() === 'GET') {
            return view('pages.dashboard.manage-product.create', compact('mode', 'categories', 'product'));
        }

        $input = $this->validate($request, [
            'category_id' => 'required|numeric',
            'pemilik_id' => 'required|numeric',
            'kode' => 'required|string',
            'nama' => 'required|string',
            'harga' => 'required|numeric',
            'deskripsi' => 'nullable|string',
            'stok' => 'nullable|numeric',
            'foto' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ], [
            'category_id.required' => 'Kategori produk wajib diisi',
            'category_id.numeric' => 'Kategori produk harus berupa angka',
            'pemilik_id.required' => 'Pemilik produk wajib diisi',
            'pemilik_id.numeric' => 'Pemilik produk harus berupa angka',
            'kode.required' => 'Kode produk wajib diisi',
            'kode.string' => 'Kode produk harus berupa string',
            'nama.required' => 'Nama produk wajib diisi',
            'nama.string' => 'Nama produk harus berupa string',
            'harga.required' => 'Harga produk wajib diisi',
            'harga.numeric' => 'Harga produk harus berupa angka',
            'deskripsi.string' => 'Deskripsi produk harus berupa string',
            'stok.numeric' => 'Stok produk harus berupa angka',
            'foto.image' => 'Foto produk harus berupa gambar',
            'foto.mimes' => 'Foto produk harus berupa gambar dengan format jpeg, png, jpg, gif, atau svg',
            'foto.max' => 'Foto produk tidak boleh lebih dari 2MB'
        ]);

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = Random::generate(10) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/imgs/product'), $filename);
            $input['foto'] = $filename;
        }

        try{
            $product->fill($input)->save();
            if ($mode === 'update') return redirect()->route('dashboard.manage-product.index')->with('success', 'Produk berhasil diubah');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', 'Produk gagal diubah');
        }
    }

    public function destroy(Request $request, $id): JsonResponse
    {
        $product = Product::find($id);
        if (!$product) return response()->json(['message' => 'Produk tidak ditemukan'], 404);

        try{
            $product->delete();
            return response()->json(['message' => 'Produk berhasil dihapus'], 200);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['message' => 'Produk gagal dihapus'], 500);
        }
    }
}
