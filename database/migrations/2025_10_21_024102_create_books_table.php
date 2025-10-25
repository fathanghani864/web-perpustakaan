<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('nama_buku', 255);
            $table->string('kategori', 100);
            $table->integer('jumlah')->default(0);
            $table->text('deskripsi')->nullable();
            $table->year('tahun_terbit')->nullable();
            $table->string('gambar_buku', 255)->nullable(); // Untuk menyimpan path file gambar
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
