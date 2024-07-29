<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionLine extends Model
{
    use HasFactory;

    protected $table = 'transaksi_detail';
    protected $fillable = [
        'hdr_id',
        'product_id',
        'cart_id',
        'sub_total',
        'waktu_sewa',
        'waktu_pengembalian',
        'status_ambil',
        'alamat'
    ];
}
