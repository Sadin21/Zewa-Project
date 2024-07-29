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

        $data = DB::table('transaksi')
                    ->join('transaksi_detail', 'transaksi.id', '=', 'transaksi_detail.hdr_id')
                    ->join('produk', 'transaksi_detail.product_id', '=', 'produk.id')
                    ->join('user', 'transaksi.user_id', '=', 'user.id')
                    ->leftJoin('keranjang', 'transaksi_detail.cart_id', '=', 'keranjang.id')
                    ->select('produk.kode', 'produk.nama', 'user.nama as penyewa', 'transaksi_detail.alamat', 'transaksi_detail.waktu_sewa', 'transaksi_detail.waktu_pengembalian', 'transaksi_detail.sub_total', 'keranjang.paket_sewa');

        if ($logedUserRole !== '1') {
            $data->where('produk.pemilik_id', $logedUserId);
        }

        return response()->json([
            'total' => $data->count(),
            'data' => $data->get(),
            'message' => 'Success get all data transaction'
        ], 200);
    }
}
