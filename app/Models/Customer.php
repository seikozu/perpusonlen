<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    // Tambahkan ini jika nama tabelmu 'customers' (plural)
    protected $table = 'customers';

    // Daftarkan kolom yang boleh diisi
    protected $fillable = ['nama', 'foto_blob', 'foto_path'];
}