<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_buku',
        'kategori',
        'jumlah',
        'deskripsi',
        'tahun_terbit',
        'gambar_buku',
    ];

    protected $casts = [
        'jumlah' => 'integer',
        'tahun_terbit' => 'integer',
    ];
}