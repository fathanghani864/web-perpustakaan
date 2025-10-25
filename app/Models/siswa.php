<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class siswa extends Model
{
        protected $table = 'siswa'; // masih pakai tabel users
    protected $fillable = ['name', 'email', 'password', 'role'];
}
