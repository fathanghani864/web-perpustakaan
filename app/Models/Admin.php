<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
       protected $table = 'users'; // masih pakai tabel users
    protected $fillable = ['name', 'email', 'password', 'role'];
}
