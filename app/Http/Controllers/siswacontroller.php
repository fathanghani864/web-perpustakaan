<?php

namespace App\Http\Controllers;

use App\Models\Book; 
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Auth; 

class SiswaController extends Controller
{
    public function index()
    {
       
        // Ambil semua buku yang stoknya lebih dari 0
        // Jika Anda ingin menampilkan yang stok 0 juga, hapus where('jumlah', '>', 0)
        $books = Book::where('jumlah', '>', 0)->get();

        // Kirim hanya variabel $books yang dibutuhkan view
        return view('siswa.index', compact('books'));
    }
}