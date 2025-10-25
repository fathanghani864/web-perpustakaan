<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Import Model yang berelasi

use App\Models\Book; 

class Peminjaman extends Model
{
    use HasFactory;
    
    // WAJIB: Menentukan nama tabel transaksi
    protected $table = 'peminjaman'; 

    protected $fillable = [
        'user_id', 
        'book_id', 
        'tanggal_pinjam', 
        'tanggal_kembali_target', 
        'tanggal_kembali_aktual',
        'status',
    ];

    protected $casts = [
        'tanggal_pinjam' => 'date',
        'tanggal_kembali_target' => 'date',
        'tanggal_kembali_aktual' => 'date',
    ];

    /**
     * Relasi ke Model Peminjam (User/Siswa)
     */
    public function peminjam()
    {
       return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi ke Model Book (Buku)
     */
    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id');
    }
}