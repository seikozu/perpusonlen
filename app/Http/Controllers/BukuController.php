<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Kategori;


class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $buku = Buku::with('kategori')->get();
        return view('buku.index', compact('buku'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategori = Kategori::all();
        return view('buku.create', compact('kategori'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'kategori_id' => 'required',
            'pengarang' => 'required',
        ]);

        // ambil kategori
        $kategori = Kategori::find($request->kategori_id);

        // tentukan prefix
        $prefix = match(strtolower($kategori->nama_kategori)) {
            'biografi' => 'BO',
            'novel' => 'NV',
            default => 'BK'
        };

        // cari kode terakhir dengan prefix sama
        $lastBuku = Buku::where('kode', 'like', $prefix . '-%')
            ->orderBy('kode', 'desc')
            ->first();

        if ($lastBuku) {
            $lastNumber = (int) substr($lastBuku->kode, 3);
            $newNumber = str_pad($lastNumber + 1, 2, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '01';
        }

        $kode = $prefix . '-' . $newNumber;

        // simpan data
        Buku::create([
            'kode' => $kode,
            'judul' => $request->judul,
            'kategori_id' => $request->kategori_id,
            'pengarang' => $request->pengarang,
            'cover' => null,
        ]);

        return redirect()->route('buku.index')->with('success', 'Buku berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $buku = Buku::findOrFail($id);
        $kategori = Kategori::all();
        return view('buku.edit', compact('buku', 'kategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $buku = Buku::findOrFail($id);
        $buku->update($request->all());

        return redirect()->route('buku.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $buku = Buku::findOrFail($id);
        $buku->delete();

        return redirect()->route('buku.index');
    }
}
