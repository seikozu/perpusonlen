<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;
use App\Models\Buku;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $jumlahKategori = Kategori::count();
        $jumlahBuku = Buku::count();

        return view('home', compact('jumlahKategori', 'jumlahBuku'));
    }
}