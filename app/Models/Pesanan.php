<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $table = 'pesanans';
    protected $primaryKey = 'idpesanan'; // Pastikan ini SAMA dengan di migration
    public $incrementing = true;
    
    protected $fillable = ['nama', 'total', 'status_bayar', 'snap_token'];
    
    // Matikan timestamps jika kamu tidak punya kolom created_at/updated_at
    // atau jika kamu pakai kolom 'timestamp' manual.
    public $timestamps = true; 
}