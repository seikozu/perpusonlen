<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Picqer\Barcode\BarcodeGeneratorPNG;

class BarangController extends Controller
{
    public function index()
    {
        $barangs = Barang::all();
        return view('barang.index', compact('barangs'));
    }

    public function print(Request $request)
    {
        $selectedIds = $request->input('ids', []);
        if (empty($selectedIds)) {
            return back()->withErrors(['ids' => 'Please select at least one item to print.']);
        }

        $barangs = \App\Models\Barang::whereIn('id_barang', $selectedIds)->get();

        $x = (int)$request->start_x;
        $y = (int)$request->start_y;

        // Rumus skip kotak berdasarkan koordinat X dan Y
        $skip = (($y - 1) * 5) + ($x - 1); 

        $generator = new BarcodeGeneratorPNG();
        $barangs = $barangs->map(function ($item) use ($generator) {
            $barcode = base64_encode($generator->getBarcode($item->id_barang, $generator::TYPE_CODE_128, 2, 40));
            $item->barcode = 'data:image/png;base64,' . $barcode;
            return $item;
        });

        $pdf = \Pdf::loadView('barang.print_pdf', compact('barangs', 'skip'))
            ->setPaper([0, 0, 595.28, 467.32]);
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

        ]);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan!');
    }
    public function create()
    {
        // Mengarahkan ke file resources/views/barang/create.blade.php
        return view('barang.create');
    }
    // Tambahkan fungsi ini di dalam class BarangController
    public function getBarangByKode($id)
    {
        // Cari berdasarkan primary key id_barang
        $barang = Barang::find($id);

        if ($barang) {
            return response()->json([
                'nama' => $barang->nama,
                'harga' => $barang->harga
            ]);
        }

        // Jika tidak ketemu, kirim null agar ditangkap catch oleh Axios
        return response()->json(null, 404);
    }
}

