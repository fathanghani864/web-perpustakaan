<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\PeminjamController;
use Illuminate\Support\Facades\Route;

// =======================
// HALAMAN UTAMA
// =======================
Route::get('/', function () {
    return view('welcome');
});

// =======================
// DASHBOARD BERDASARKAN ROLE
// =======================
Route::get('/dashboard', function () {
    if (auth()->check()) {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.index');
        } else if (auth()->user()->role === 'siswa') {
            return redirect()->route('siswa.index');
        }
    }
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// =======================
// PROFIL PENGGUNA
// =======================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// =======================
// ADMIN AREA
// =======================
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard Admin
        Route::get('/', [AdminController::class, 'index'])->name('index');

        // --- CRUD BUKU ---
        Route::post('/admin/books', [BookController::class, 'store'])->name('admin.books.store');
        Route::get('/books', [BookController::class, 'index'])->name('books.index');
        Route::get('/tambah_buku', [BookController::class, 'create'])->name('tambah_buku');
        Route::get('/books/{book}/edit', [BookController::class, 'edit'])->name('books.edit');
        Route::put('/books/{book}', [BookController::class, 'update'])->name('books.update');
        Route::delete('/books/{book}', [BookController::class, 'destroy'])->name('books.destroy');
        Route::get('/daftar_peminjaman', [PeminjamController::class, 'index'])
            ->name('peminjaman.index');
       



    });

// =======================
// SISWA AREA
// =======================
Route::middleware(['auth', 'role:siswa'])->group(function () {
    Route::get('/siswa', [SiswaController::class, 'index'])->name('siswa.index');

    Route::prefix('pinjam')->name('pinjam.')->group(function () {
        Route::post('/', [PeminjamController::class, 'store'])->name('store');
    });
});

require __DIR__ . '/auth.php';
