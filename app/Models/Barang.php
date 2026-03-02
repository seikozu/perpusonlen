<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = 'barang';
    protected $primaryKey = 'id_barang';
    public $incrementing = false; // Karena id_barang adalah string/varchar
    protected $keyType = 'string';
    
    protected $fillable = ['id_barang', 'nama', 'harga', 'timestamp'];
    public $timestamps = false; // Kita pakai timestamp manual dari database
}