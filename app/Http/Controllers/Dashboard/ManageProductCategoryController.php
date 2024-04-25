<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Models\ProductCategory;

class ManageProductCategoryController extends Controller
{
    public function index(): View
    {
        return view('pages.dashboard.manage-product-category.index');
    }

    public function getAllData(Request $request): JsonResponse
    {
        $data = DB::table('product_categories')
                    ->leftJoin('products', 'products.category_id', '=', 'product_categories.id')
                    ->select('product_categories.id', 'product_categories.nama', DB::raw('COALESCE(COUNT(products.id), 0) as total'))
                    ->groupBy('product_categories.id')
                    ->get();

        return response()->json([
            'total' => $data->count(),
            'data' => $data,
            'message' => 'Success get all data'
        ], 200);
    }

    public function create(Request $request): mixed
    {
        $mode = 'create';

        if ($request->getMethod() === 'GET') {
            return view('pages.dashboard.manage-product-category.create', compact('mode'));
        }

        $input = $this->validate($request, [
            'nama' => 'required|string'
        ], [
            'nama.required' => 'Nama wajib diisi',
            'nama.string' => 'Nama harus berupa text'
        ]);

        try{
            ProductCategory::create($input);
            return redirect()->route('dashboard.manage-product-category.index')->with('success', 'Kategori produk berhasil dibuat');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', 'Kategori produk gagal dibuat');
        }
    }

    public function update(Request $request, string $id): mixed
    {
        $mode = 'update';
        $category = ProductCategory::find($id);

        if (!$category) return redirect()->route('dashboard.manage-product-category.index')->with('error', 'Kategori produk tidak ditemukan');

        if ($request->getMethod() === 'GET') {
            return view('pages.dashboard.manage-product-category.create', compact('mode', 'category'));
        }

        $input = $this->validate($request, [
            'nama' => 'required|string'
        ], [
            'nama.required' => 'Nama wajib diisi',
            'nama.string' => 'Nama harus berupa text'
        ]);

        try{
            $category->fill($input)->save();
            if ($mode === 'update') return redirect()->route('dashboard.manage-product-category.index')->with('success', 'Kategori produk berhasil diubah');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', 'Kategori produk gagal diubah');
        }
    }

    public function destroy(Request $request, $id): JsonResponse
    {
        $category = ProductCategory::find($id);
        if (!$category) return response()->json(['message' => 'Kategori produk tidak ditemukan'], 404);

        try{
            $category->delete();
            return response()->json(['message' => 'Kategori produk berhasil dihapus'], 200);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['message' => 'Kategori produk gagal dihapus'], 500);
        }
    }
}
