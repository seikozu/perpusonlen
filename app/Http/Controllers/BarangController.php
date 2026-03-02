<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class BarangController extends Controller
{
    public function index()
    {
        $barangs = Barang::all();
        return view('barang.index', compact('barangs'));
    }

    public function print(Request $request)
    {
        $selectedIds = $request->ids;
        $barangs = \App\Models\Barang::whereIn('id_barang', $selectedIds)->get();

        $x = (int)$request->start_x;
        $y = (int)$request->start_y;

        // Rumus skip kotak berdasarkan koordinat X dan Y
        $skip = (($y - 1) * 5) + ($x - 1); 

        $pdf = \Pdf::loadView('barang.print_pdf', compact('barangs', 'skip'));
        return $pdf->stream('tag-harga.pdf');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|max:50',
            'harga' => 'required|numeric',
        ]);

        \App\Models\Barang::create([
            'nama' => $request->nama,
            'harga' => $request->harga,
            // id_barang & timestamp otomatis terisi oleh trigger database
        ]);

        return redirect()->back()->with('success', 'Barang berhasil ditambahkan!');
    }
}

