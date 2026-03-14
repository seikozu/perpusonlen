<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function simpanTransaksi(Request $request)
    {
        DB::beginTransaction();
        try {
            // 1. Simpan ke tabel Master (Penjualan)
            $penjualan = Penjualan::create([
                'total'     => $request->total,
                'timestamp' => now()
            ]);

            // 2. Simpan ke tabel Detail (PenjualanDetail)
            foreach ($request->items as $item) {
                PenjualanDetail::create([
                    'id_penjualan' => $penjualan->id_penjualan,
                    'id_barang'    => $item['kode'],
                    'jumlah'       => $item['qty'],
                    'subtotal'     => $item['subtotal']
                ]);
            }

            DB::commit();
            return response()->json(['message' => 'Transaksi Berhasil!'], 200);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Gagal: ' . $e->getMessage()], 500);
        }
    }
}