<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPesanan extends Model
{
    protected $table = 'detail_pesanans';
    
    // CRITICAL: Kasih tahu Laravel kalau tabel ini nggak punya kolom "id"
    public $incrementing = true; 
    protected $primaryKey = 'iddetail_pesanan'; 

    protected $fillable = [
        'idpesanan', 
        'idmenu', 
        'jumlah', 
        'harga', 
        'subtotal', 
        'catatan'
    ];

    public $timestamps = false;
}