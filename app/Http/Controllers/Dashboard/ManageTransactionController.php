<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class ManageTransactionController extends Controller
{
    public function index(): View
    {
        return view('pages.dashboard.manage-transaction.index');
    }

    public function getAllData(Request $request): JsonResponse
    {
        $logedUserId = $request->query('logedUserId');
        $logedUserRole = $request->query('logedUserRole');

        $data = DB::table('transaction_hdrs')
                    ->join('transaction_lines', 'transaction_hdrs.id', '=', 'transaction_lines.hdr_id')
                    ->join('products', 'transaction_lines.product_id', '=', 'products.id')
                    ->join('users', 'transaction_hdrs.user_id', '=', 'users.id')
                    ->leftJoin('carts', 'transaction_lines.cart_id', '=', 'carts.id')
                    ->select('products.kode', 'products.nama', 'users.nama as penyewa', 'transaction_lines.alamat', 'transaction_lines.waktu_sewa', 'transaction_lines.waktu_pengembalian', 'transaction_lines.sub_total', 'carts.paket_sewa');

        if ($logedUserRole !== '1') {
            $data->where('products.pemilik_id', $logedUserId);
        }

        return response()->json([
            'total' => $data->count(),
            'data' => $data->get(),
            'message' => 'Success get all data transaction'
        ], 200);
    }
}
