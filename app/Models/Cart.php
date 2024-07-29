<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $table = 'keranjang';
    protected $fillable = [
        'product_id',
        'user_id',
        'waktu_sewa',
        'paket_sewa',
        'waktu_pengembalian',
        'status_ambil',
        'alamat',
    ];
}
