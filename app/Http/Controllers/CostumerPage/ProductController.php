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
    public function getAllData(Request $request): View | RedirectResponse
    {
        $keyword = $request->keyword;
        $order = $request->order;
        $orderBy = $request->orderBy;
        $nama = $request->nama?? 0;
        $kategori = $request->kategori?? 0;
        $pemilik = $request->pemilik?? 0;

        $product = DB::table('products')
                    ->join('product_categories', 'products.category_id', '=', 'product_categories.id')
                    ->join('users', 'products.pemilik_id', '=', 'users.id')
                    ->select('products.id', 'products.nama', 'products.harga', 'products.foto', 'products.stok', 'products.deskripsi', 'product_categories.nama as category', 'users.nama as pemilik')
                    ->where(function ($query) use ($nama) {
                        if ($nama) {
                            $query->where('products.nama', 'like', '%'.$nama.'%');
                        }
                    })
                    ->orWhere(function ($query) use ($kategori) {
                        if ($kategori) {
                            $query->where('product_categories.nama', 'like', '%'.$kategori.'%');
                        }
                    })
                    ->orWhere(function ($query) use ($pemilik) {
                        if ($pemilik) {
                            $query->where('users.nama', 'like', '%'.$pemilik.'%');
                        }
                    });

        // if ($keyword) {

        // }

        $product = $product->get();
        // dd($product);

        // return response()->json([
        //     'totalRecords' => $product->count(),
        //     'status' => 'success',
        //     'data' => $product
        // ]);

        return view('pages.customer-page.product.index', compact('product'));
    }

    public function getDetailData($id): View
    {
        $product = DB::table('products')
                    ->join('product_categories', 'products.category_id', '=', 'product_categories.id')
                    ->join('users', 'products.pemilik_id', '=', 'users.id')
                    ->select('products.id', 'products.nama', 'products.harga', 'products.foto', 'products.stok', 'products.deskripsi', 'product_categories.nama as category', 'users.nama as pemilik')
                    ->where('products.id', $id)
                    ->first();

        return view('pages.customer-page.product.detail', compact('product'));
    }
}
