<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Kategori;

class BukuController extends Controller
{
    public function index()
    {
        // Mengambil data buku beserta relasi kategorinya
        $buku = Buku::with('kategori')->get();
        return view('buku.index', compact('buku'));
    }

    public function create()
    {
        $kategori = Kategori::all();
        return view('buku.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'judul' => 'required',
            'pengarang' => 'required',
        ]);

        // 2. Ambil data kategori
        $kategori = Kategori::findOrFail($request->kategori_id);
        
        // 3. Logika generate kode otomatis (Novel -> NV, Biografi -> BI)
        $inisial = strtoupper(substr($kategori->nama_kategori, 0, 2));

        // Cari kode terakhir dengan inisial tersebut di database PostgreSQL
        $lastBook = Buku::where('kode', 'LIKE', $inisial . '-%')
                        ->orderBy('kode', 'desc')
                        ->first();

        if ($lastBook) {
            $lastNumber = (int) substr($lastBook->kode, 3);
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }

        $newCode = $inisial . '-' . str_pad($nextNumber, 2, '0', STR_PAD_LEFT);

        // 4. Simpan ke Database dengan nama kolom sesuai pgAdmin
        Buku::create([
            'kode' => $newCode,
            'judul' => $request->judul,
            'kategori_id' => $request->kategori_id, // Kolom: kategori_id
            'pengarang' => $request->pengarang,     // Kolom: pengarang
        ]);

        return redirect()->route('buku.index')->with('success', 'Buku berhasil ditambahkan dengan kode ' . $newCode);
    }

    public function edit(string $id)
    {
        $buku = Buku::findOrFail($id);
        $kategori = Kategori::all();
        return view('buku.edit', compact('buku', 'kategori'));
    }

    public function update(Request $request, string $id)
    {
        $buku = Buku::findOrFail($id);
        
        // Pastikan update menggunakan data yang tervalidasi
        $buku->update([
            'judul' => $request->judul,
            'kategori_id' => $request->kategori_id,
            'pengarang' => $request->pengarang,
        ]);

        return redirect()->route('buku.index')->with('success', 'Data buku berhasil diperbarui');
    }

    public function destroy(string $id)
    {
        $buku = Buku::findOrFail($id);
        $buku->delete();

        return redirect()->route('buku.index')->with('success', 'Buku berhasil dihapus');
    }
}