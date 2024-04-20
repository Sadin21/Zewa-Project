<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionHdr extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'no_transaksi',
        'total_qty',
        'grand_total',
        'payment',
        'uang_dibayar',
        'status',
        'snap_token'
    ];
}
