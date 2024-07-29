<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\TransactionHdr;
use App\Models\TransactionLine;
use App\Models\Product;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function downloadInvoice(Request $request)
    {
        $id = $request->query('id');

        $data = DB::table('transkasi')
                ->join('user', 'transkasi.user_id', '=', 'user.id')
                ->select(
                    'user.nama as customer',
                    'user.alamat as alamat',
                    'user.email as email',
                    'transkasi.no_transaksi as no_transaksi',
                    'transkasi.created_at as tanggal',
                    'transkasi.grand_total as grand_total',
                )
                ->where('transkasi.id', $id)
                ->first();

        $transaction_lines = DB::table('transaksi_detail')
                            ->join('produk', 'transaksi_detail.product_id', '=', 'produk.id')
                            ->select(
                                'produk.nama as nama_barang',
                                'produk.harga as harga',
                                'produk.kode as kode',
                                'transaksi_detail.sub_total as sub_total',
                                'transaksi_detail.waktu_sewa as waktu_sewa',
                                'transaksi_detail.waktu_pengembalian as waktu_pengembalian',
                            )
                            ->where('transaction_lines.hdr_id', $id)
                            ->get();

        // return view('pages.invoice.index', compact('data', 'transaction_lines'));

        $pdf = PDF::loadView('pages.invoice.index', compact('data', 'transaction_lines'));
        return $pdf->download('struk penyewaan.pdf');
    }
}
