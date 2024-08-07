<?php

namespace App\Http\Controllers\CostumerPage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\TransactionHdr;
use App\Models\TransactionLine;
use App\Models\Product;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{

    public function index(Request $request): View | RedirectResponse
    {
        $data = DB::table('transaksi_detail')
            ->join('transaksi', 'transaksi_detail.hdr_id', '=', 'transaksi.id')
            ->join('produk', 'transaksi_detail.product_id', '=', 'produk.id')
            ->select('transaksi_detail.*', 'transaksi.id as hdr_id', 'transaksi.no_transaksi', 'produk.nama', 'produk.kode', 'produk.foto')
            ->where('transaksi.user_id', Auth::user()->id)
            ->get();

        return view('pages.customer-page.transaction.index', compact('data'));
    }

    public function process(Request $request)
    {
        $data = $request->all();

        if (auth()->user() === null) {
            return response()->json([
                'message' => 'Anda harus login terlebih dahulu'
            ], 400);
        }

        $selectedProduct = $data['selectedProduct'];
        $grandTotal = $data['grandTotal'];
        $totalQty = $data['totalQty'];
        $directPayment = $data['directPayment'];

        DB::beginTransaction();

        try {
            $transaction_hdr = TransactionHdr::create([
                'user_id' => auth()->user()->id,
                'no_transaksi' => 'TRX'.time(),
                'total_qty' => $totalQty,
                'grand_total' => $grandTotal,
                'payment' => 'MIDTRANS',
                'uang_dibayar' => $grandTotal,
                'status' => 'PENDING',
            ]);

            // Set your Merchant Server Key
            \Midtrans\Config::$serverKey = config('midtrans.serverKey');
            // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
            \Midtrans\Config::$isProduction = false;
            // Set sanitization on (default)
            \Midtrans\Config::$isSanitized = true;
            // Set 3DS transaction for credit card to true
            \Midtrans\Config::$is3ds = true;

            $params = array(
                'transaction_details' => array(
                    'order_id' => rand(),
                    'gross_amount' => $grandTotal,
                ),
                'customer_details' => array(
                    'first_name' => Auth::user()->name,
                    'email' => Auth::user()->email,
                )
            );

            $snapToken = \Midtrans\Snap::getSnapToken($params);

            $transaction_hdr->snap_token = $snapToken;
            $transaction_hdr->save();

            $now = date('Y-m-d H:i:s');

            // store to database
            if ($directPayment !== '1') {
                foreach ($selectedProduct as $p) {
                    $product = Product::where('nama', $p['productName'])->first();

                    if ($p['statusAmbil'] === 'antar' && $p['alamat'] === null) {
                        return response()->json([
                            'message' => 'Alamat harus diisi'
                        ], 400);
                    }

                    if ($product->stok < 1) {
                        return response()->json([
                            'message' => 'Stok produk tidak mencukupi'
                        ], 400);
                    }


                    if (auth()->user()->role_id != '3') {
                        return response()->json([
                            'message' => 'Anda tidak bisa menyewa produk'
                        ], 400);
                    }

                    $product->stok = $product->stok - 1;
                    $product->tersewakan = $product->tersewakan + 1;
                    $product->save();

                    TransactionLine::create([
                        'hdr_id' => $transaction_hdr->id,
                        'product_id' => $product->id,
                        'cart_id' => $p['cartId'],
                        'sub_total' => $p['subTotal'],
                        'waktu_sewa' => $p['waktuSewa'],
                        'waktu_pengembalian' => $p['waktuPengembalian'],
                        'status_ambil' => $p['statusAmbil'],
                        'alamat' => $p['alamat']? $p['alamat'] : null,
                    ]);
                }
            } else {
                $product = Product::findOrFail($selectedProduct['productId']);

                if ($product->stok < 1) {
                    return response()->json([
                        'message' => 'Stok produk tidak mencukupi'
                    ], 400);
                }

                if (auth()->user()->role_id != '3') {
                    return response()->json([
                        'message' => 'Anda tidak bisa menyewa produk'
                    ], 400);
                }

                $product->stok = $product->stok - 1;
                $product->tersewakan = $product->tersewakan + 1;
                // $product->tersewakan = $product->tersewakan + intval($totalQty);
                $product->save();

                if ($product) {
                    TransactionLine::create([
                        'hdr_id' => $transaction_hdr->id,
                        'product_id' => $product->id,
                        'cart_id' => isset($selectedProduct['cartId']) ? $selectedProduct['cartId'] : null,
                        'sub_total' => $selectedProduct['subTotal'],
                        'waktu_sewa' => $selectedProduct['waktuSewa'],
                        'waktu_pengembalian' => $selectedProduct['waktuPengembalian'],
                        'status_ambil' => $selectedProduct['statusAmbil'],
                        'alamat' => $selectedProduct['alamat']? $selectedProduct['alamat'] : null,
                    ]);
                }
            }

            DB::commit();

            return [
                'snapToken' => $snapToken,
                'transactionHdrId' => $transaction_hdr->id
            ];
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th);
            return redirect()->back()->with('error', 'Transaksi gagal');
        }
    }

    public function updatePaymentStatus(Request $request)
    {
        $transactionHdrId = $request->query('transactionHdrId');
        $transactionHdr = TransactionHdr::find($transactionHdrId);

        if (!$transactionHdr) {
            // Handle case where transactionHdrId is not found
            return abort(404);
        }

        $transactionHdr->status = 'SUCCESS';
        $transactionHdr->save();

        return redirect()->route('transaction.index')->with('success', 'Pembayaran berhasil');
    }
}
