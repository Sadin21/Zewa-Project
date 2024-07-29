<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'produk';
    protected $fillable = [
        'category_id',
        'pemilik_id',
        'kode',
        'nama',
        'harga',
        'deskripsi',
        'stok',
        'foto'
    ];
}
