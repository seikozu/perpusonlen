<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $table = 'vendors';
    protected $primaryKey = 'idvendor'; // Sesuai ERD 
    protected $fillable = ['nama_vendor'];
    public $timestamps = true;

    // Relasi: Satu vendor punya banyak menu 
    public function menus()
    {
        return $this->hasMany(Menu::class, 'idvendor', 'idvendor');
    }
}