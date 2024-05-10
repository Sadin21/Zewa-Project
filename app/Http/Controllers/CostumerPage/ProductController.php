<?php

namespace App\Http\Controllers\CostumerPage;

use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index(): View
    {
        $categoryData = DB::table('products')
            ->join('product_categories', 'products.category_id', '=', 'product_categories.id')
            ->select('category_id', DB::raw('count(*) as total'), 'product_categories.nama as category')
            ->groupBy('category_id')
            ->get();

        return view('pages.customer-page.product.index', compact('categoryData'));
    }

    public function getAllData(Request $request)
    {
        $keyword = $request->keyword;
        $order = $request->order;
        $orderBy = $request->orderBy;
        $nama = $request->nama?? 0;
        $category = $request->category?? 0;
        $pemilik = $request->pemilik?? 0;

        $product = DB::table('products')
                    ->join('product_categories', 'products.category_id', '=', 'product_categories.id')
                    ->join('users', 'products.pemilik_id', '=', 'users.id')
                    ->select('products.id', 'products.nama', 'products.harga', 'products.foto', 'products.stok', 'products.deskripsi', 'products.tersewakan', 'product_categories.nama as category', 'users.nama as pemilik')
                    ->where(function ($query) use ($nama) {
                        if ($nama) {
                            $query->where('products.nama', 'like', '%'.$nama.'%');
                        }
                    })
                    ->orWhere(function ($query) use ($category) {
                        if ($category) {
                            $query->where('product_categories.nama', 'like', '%'.$category.'%');
                        }
                    })
                    ->orWhere(function ($query) use ($pemilik) {
                        if ($pemilik) {
                            $query->where('users.nama', 'like', '%'.$pemilik.'%');
                        }
                    });

        $product = $product->get();

        return response()->json([
            'totalRecords' => $product->count(),
            'data' => $product,
            'message' => 'Success get data'
        ], 200);

        // return view('pages.customer-page.product.index', compact('product'));
    }

    public function getDetailData($id): View
    {
        $product = DB::table('products')
                    ->join('product_categories', 'products.category_id', '=', 'product_categories.id')
                    ->join('users', 'products.pemilik_id', '=', 'users.id')
                    ->select('products.id', 'products.nama', 'products.harga', 'products.foto', 'products.stok', 'products.deskripsi', 'products.tersewakan', 'product_categories.nama as category', 'users.nama as pemilik')
                    ->where('products.id', $id)
                    ->first();

        return view('pages.customer-page.product.detail', compact('product'));
    }

    public function getDataByName(Request $request)
    {
        $data = [];

        if ($request->has('q')) {
            // $search = $request->q;
            $search = 'Kain';

            $data = DB::table('products')
                ->select('id', 'nama')
                ->where('nama', 'LIKE', "%$search%")
                ->get();
        }

        return response()->json($data);
    }
}
