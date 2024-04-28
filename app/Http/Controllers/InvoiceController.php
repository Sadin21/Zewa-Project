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

        $data = DB::table('transaction_hdrs')
                ->join('users', 'transaction_hdrs.user_id', '=', 'users.id')
                ->select(
                    'users.nama as customer',
                    'users.alamat as alamat',
                    'users.email as email',
                    'transaction_hdrs.no_transaksi as no_transaksi',
                    'transaction_hdrs.created_at as tanggal',
                    'transaction_hdrs.grand_total as grand_total',
                )
                ->where('transaction_hdrs.id', $id)
                ->first();

        $transaction_lines = DB::table('transaction_lines')
                            ->join('products', 'transaction_lines.product_id', '=', 'products.id')
                            ->select(
                                'products.nama as nama_barang',
                                'products.harga as harga',
                                'products.kode as kode',
                                'transaction_lines.sub_total as sub_total',
                                'transaction_lines.waktu_sewa as waktu_sewa',
                                'transaction_lines.waktu_pengembalian as waktu_pengembalian',
                            )
                            ->where('transaction_lines.hdr_id', $id)
                            ->get();

        // return view('pages.invoice.index', compact('data', 'transaction_lines'));

        $pdf = PDF::loadView('pages.invoice.index', compact('data', 'transaction_lines'));
        return $pdf->download('struk penyewaan.pdf');
    }
}
