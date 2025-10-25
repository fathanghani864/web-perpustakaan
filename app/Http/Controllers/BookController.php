<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage; 
use Illuminate\Support\Str;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    // Direktori tempat cover buku disimpan di dalam folder 'public'
    const COVER_PATH = 'covers'; 

    public function index()
    {
        $books = Book::all(); 
        // Pastikan view ini yang memiliki tabel buku dan tombol Edit
        return view('admin.index', compact('books'));
    }

    public function create()
    {
        return view('admin.tambah_buku');
    }

    public function store(Request $request)
    {
        // 1. Validasi Data
        $validated = $request->validate([
            'nama_buku'    => 'required|string|max:255',
            'kategori'     => 'required|string|max:100',
            'jumlah'       => 'required|integer|min:0',
            'deskripsi'    => 'nullable|string',
            'tahun_terbit' => 'nullable|integer|min:1900|max:' . date('Y'),
            'gambar_buku'  => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // 2MB max
        ]);

        // 2. Handle Upload Gambar
        if ($request->hasFile('gambar_buku')) {
            // Simpan file ke direktori storage/app/public/covers
            $path = $request->file('gambar_buku')->store(self::COVER_PATH, 'public');
            
            // Simpan path lengkap (misal: covers/namafile.jpg) ke database
            $validated['gambar_buku'] = $path;
        } else {
             // Pastikan gambar_buku tidak masuk ke data jika tidak diupload
             unset($validated['gambar_buku']);
        }

        // 3. Simpan Data ke Database
        try {
            Book::create($validated);
            return redirect()->route('admin.index')->with('success', 'Buku berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan buku: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan formulir untuk mengedit buku.
     * @param Book $book (Route Model Binding)
     */
    public function edit(Book $book)
    {
        // Kode ini sudah sempurna, ia mencari buku berdasarkan ID dan mengirimkannya ke view
        return view('admin.edit_buku', compact('book'));
    }

    /**
     * Memperbarui data buku di database.
     * @param Request $request
     * @param Book $book (Route Model Binding)
     */
    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'nama_buku'    => 'required|string|max:255',
            'kategori'     => 'required|string|max:100',
            'jumlah'       => 'required|integer|min:0',
            'deskripsi'    => 'nullable|string', 
            'tahun_terbit' => 'nullable|integer|min:1900|max:' . date('Y'),
            // Aturan validasi tidak perlu 'required' karena ini update
            'gambar_buku'  => 'nullable|image|mimes:jpeg,png,jpg|max:2048', 
        ]);
        
        $dataToUpdate = $validated;

        // Cek apakah ada file gambar baru di-upload
        if ($request->hasFile('gambar_buku')) {
            // 1. Hapus gambar lama jika ada
            if ($book->gambar_buku) {
                // Pastikan menggunakan path lengkap yang tersimpan di database
                Storage::disk('public')->delete($book->gambar_buku); 
            }

            // 2. Simpan gambar baru dan dapatkan path-nya
            $path = $request->file('gambar_buku')->store(self::COVER_PATH, 'public');
            
            // Simpan path baru ke array update
            $dataToUpdate['gambar_buku'] = $path; 

        } else {
            // Jika tidak ada file baru di-upload, hapus 'gambar_buku' dari array $dataToUpdate 
            // agar path gambar lama tidak ditimpa oleh NULL
            unset($dataToUpdate['gambar_buku']); 
        }

        // 3. Update data buku
        $book->update($dataToUpdate);
        return redirect()->route('admin.index')->with('success', 'Data buku berhasil diperbarui!');
    }

    public function destroy(Book $book)
    {
        // Hapus file dari storage sebelum menghapus record dari database
        if ($book->gambar_buku) {
            // Path lengkap (misal: covers/namafile.jpg)
            Storage::disk('public')->delete($book->gambar_buku); 
        }

        $book->delete();
        // Menggunakan route index yang benar
        return redirect()->route('admin.index')->with('success', 'Buku berhasil dihapus!');
    }
}
