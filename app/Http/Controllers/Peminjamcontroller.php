<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman; 
use App\Models\Book; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Auth;

class PeminjamController extends Controller
{
    /**
     * Menampilkan daftar peminjaman untuk Admin.
     */
    public function index()
    {
        // Ambil semua data peminjaman beserta relasi user dan book
        // Pastikan Anda memiliki relasi 'user' di Model Peminjaman yang mengacu ke App\Models\User
        $peminjaman = Peminjaman::with(['peminjam', 'book'])->latest()->get(); 
        
        return view('admin.daftar_peminjaman', compact('peminjaman'));
    }

    /**
     * Aksi untuk mengajukan peminjaman buku oleh Siswa.
     * Route: POST /pinjam (pinjam.store)
     */
    public function store(Request $request)
    {
        // 0. Validasi Input Masuk
        // Validasi ini memastikan book_id ada dan valid, sehingga error SQLSTATE teratasi
        $request->validate([
            'book_id' => 'required|exists:books,id', 
        ]);
        
        $userId = Auth::id();
        $bookId = $request->book_id;

        // 1. Cek ketersediaan stok
        $book = Book::find($bookId);
        if (!$book || $book->jumlah <= 0) {
            return redirect()->back()->with('error', 'Stok buku "' . $book->nama_buku . '" sedang habis.');
        }

        // 2. Cek apakah Siswa sudah meminjam buku ini atau sedang mengajukan
        $existingBorrow = Peminjaman::where('user_id', $userId)
            ->where('book_id', $bookId)
            ->whereIn('status', ['Diajukan', 'Dipinjam']) 
            ->first();

        if ($existingBorrow) {
            return redirect()->back()->with('error', 'Anda sudah meminjam atau sedang mengajukan buku ini.');
        }

        // 3. Buat Peminjaman baru
        try {
            Peminjaman::create([
                'user_id' => $userId,
                'book_id' => $bookId, // book_id PASTI terkirim ke database sekarang
                'status' => 'Diajukan', 
            ]);

            return redirect()->back()->with('success', 'Permintaan peminjaman buku "' . $book->nama_buku . '" berhasil diajukan! Menunggu persetujuan admin.');

        } catch (\Exception $e) {
            // Tampilkan error yang lebih informatif jika masih terjadi masalah
            return redirect()->back()->with('error', 'Gagal mengajukan peminjaman. Silakan coba lagi. Error: ' . $e->getMessage());
        }
    }

    /**
     * Aksi untuk menyetujui peminjaman (admin.peminjaman.setuju).
     */
    public function approve($id)
    {
        DB::beginTransaction();

        try {
            $peminjaman = Peminjaman::findOrFail($id);
            
            if ($peminjaman->status !== 'Diajukan') {
                 DB::rollBack();
                 return redirect()->route('admin.peminjaman.index')->with('warning', 'Peminjaman sudah diproses sebelumnya.');
            }

            $book = $peminjaman->book;
            if ($book->jumlah <= 0) {
                DB::rollBack();
                $peminjaman->status = 'Ditolak';
                $peminjaman->save();
                return redirect()->route('admin.peminjaman.index')->with('error', 'Gagal menyetujui: Stok buku "' . $book->nama_buku . '" sedang habis. Peminjaman ditolak.');
            }

            $peminjaman->status = 'Dipinjam';
            $peminjaman->tanggal_pinjam = now(); // Set tanggal pinjam resmi
            $peminjaman->save();
            
            $book->decrement('jumlah');

            DB::commit();
            return redirect()->route('admin.peminjaman.index')->with('success', 'Peminjaman berhasil disetujui! Stok buku dikurangi.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.peminjaman.index')->with('error', 'Gagal menyetujui peminjaman. Error: ' . $e->getMessage());
        }
    }

    /**
     * Aksi untuk konfirmasi pengembalian buku (admin.peminjaman.kembali).
     */
    public function returnBook($id)
    {
        DB::beginTransaction();
        
        try {
            $peminjaman = Peminjaman::findOrFail($id);

            if ($peminjaman->status != 'Dipinjam') {
                 DB::rollBack();
                 if ($peminjaman->status == 'Dikembalikan') {
                     return redirect()->route('admin.peminjaman.index')->with('warning', 'Buku sudah dikembalikan sebelumnya.');
                 }
                 return redirect()->route('admin.peminjaman.index')->with('error', 'Buku tidak dalam status "Dipinjam".');
            }

            $peminjaman->status = 'Dikembalikan';
            $peminjaman->tanggal_kembali_aktual = now(); // Set tanggal kembali aktual
            $peminjaman->save();

            $book = $peminjaman->book;
            $book->increment('jumlah');

            DB::commit();
            return redirect()->route('admin.peminjaman.index')->with('success', 'Pengembalian buku berhasil dikonfirmasi! Stok buku telah dikembalikan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.peminjaman.index')->with('error', 'Gagal mengkonfirmasi pengembalian buku. Error: ' . $e->getMessage());
        }

        
    }

   public function edit($id)
{
    $peminjaman = Peminjaman::findOrFail($id);
    return view('admin.edit_peminjaman', compact('peminjaman'));
}

public function update(Request $request, $id)
{
    $peminjaman = Peminjaman::findOrFail($id);
    $peminjaman->status = $request->status;
    $peminjaman->save();

    return redirect()->route('admin.peminjaman')
                     ->with('success', 'Status peminjaman berhasil diperbarui!');
}
}
