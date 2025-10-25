<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Book;



class admincontroller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      
         $books = Book::all(); // Data buku
    $admin = Admin::all(); // Data admin (sekarang sudah benar)
    
    // Pastikan kedua variabel dikirim!
    return view("admin.index", compact("admin", "books")); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
{
    $peminjaman = Peminjaman::findOrFail($id);
    return view('admin.edit_peminjaman', compact('peminjaman'));
}



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    $peminjaman = Peminjaman::findOrFail($id);
    $peminjaman->status = $request->status;
    $peminjaman->save();

    return redirect()->route('admin.peminjaman')
                     ->with('success', 'Status peminjaman berhasil diperbarui!');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
