<?php

namespace App\Http\Controllers\CostumerPage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;

class ProductCategoryController extends Controller
{
    public function getAllData(Request $request): JsonResponse
    {
        $keyword = $request->keyword;
        $nama = $request->nama?? 0;

        $data = DB::table('product_categories')
                        ->select('id', 'nama')
                        ->where(function ($query) use ($nama) {
                            if ($nama) {
                                $query->where('nama', 'LIKE', '%' . $nama . '%');
                            }
                        });

        if ($keyword) {
            $data->where(function ($d) use ($keyword) {
                $d->where('nama', 'LIKE', '%' . $keyword . '%');
            });
        }

        return response()->json([
            'totalRecords' => $data->count(),
            'data' => $data->get(),
            'message' => 'Success get data'
        ], 200);
    }
}
