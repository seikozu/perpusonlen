<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    protected $table = 'penjualan';
    protected $primaryKey = 'id_penjualan';
    public $timestamps = false; // Karena kita pakai kolom 'timestamp' manual
    protected $fillable = ['total', 'timestamp'];
}
