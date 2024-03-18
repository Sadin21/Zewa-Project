<?php

namespace App\Http\Controllers\CostumerPage;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;


class HomeController extends Controller
{
    public function index(Request $request): View | RedirectResponse
    {
        $newProduct = Product::orderBy('created_at', 'desc')->limit(4)->get();

        $totalCategoryProduct = DB::table('products')
                                    ->join('product_categories', 'products.category_id', '=', 'product_categories.id')
                                    ->select('category_id', DB::raw('count(*) as total'), 'product_categories.nama as category')
                                    ->groupBy('category_id')
                                    ->get();

        // dd($totalCategoryProduct);

        return view('pages.customer-page.home.index', compact('newProduct', 'totalCategoryProduct'));
    }
}
