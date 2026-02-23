<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Kategori;
use App\Models\Buku;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUser = User::count();
        $totalKategori = Kategori::count();
        $totalBuku = Buku::count();

        return view('dashboard', compact(
            'totalUser',
            'totalKategori',
            'totalBuku'
        ));
    }
}
