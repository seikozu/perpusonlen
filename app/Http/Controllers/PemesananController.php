<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Vendor;
use App\Models\Menu;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class PemesananController extends Controller
{
    public function index()
    {
        $vendors = Vendor::all();
        // Ambil data pesanan lunas untuk monitoring
        $pesananLunas = Pesanan::where('status_bayar', 1)
                                ->orderBy('idpesanan', 'desc')
                                ->get();

        return view('modul6.pemesanan', compact('vendors', 'pesananLunas'));
    }

    public function getMenus($idvendor)
    {
        // Mengambil menu via AJAX
        $menus = Menu::where('idvendor', $idvendor)->get();
        return response()->json($menus);
    }

    public function checkout(Request $request)
    {
        // Pastikan ada item di keranjang
        if (!$request->has('items') || empty($request->items)) {
            return response()->json(['error' => 'Keranjang belanja kosong!'], 400);
        }

        DB::beginTransaction();
        try {
            // 1. Simpan Header Pesanan
            $pesanan = new Pesanan();
            // Jika login pakai nama user, jika tidak pakai Guest_Random
            $pesanan->nama = auth()->check() ? auth()->user()->name : "Guest_" . Str::random(5);
            $pesanan->total = (int)$request->total;
            $pesanan->status_bayar = 0; // Belum bayar
            $pesanan->save();

            // 2. Simpan Detail Pesanan
            foreach ($request->items as $item) {
                DetailPesanan::create([
                    'idpesanan' => $pesanan->idpesanan,
                    'idmenu'    => $item['idmenu'],
                    'jumlah'    => $item['qty'],
                    'harga'     => $item['harga'],
                    'subtotal'  => $item['subtotal'],
                ]);
            }

            // 3. Eksekusi ke Midtrans via HTTP Client (Direct API)
            $serverKey = config('services.midtrans.server_key');
            if (empty($serverKey)) {
                throw new \Exception('Midtrans server key tidak dikonfigurasi. Periksa file .env.');
            }

            $response = Http::withBasicAuth($serverKey, '')
                ->withHeaders([
                    'Accept'       => 'application/json',
                    'Content-Type' => 'application/json',
                ])
                ->withoutVerifying() // Solusi jitu untuk error SSL Laragon/Windows
                ->timeout(30)
                ->post('https://app.sandbox.midtrans.com/snap/v1/transactions', [
                    'transaction_details' => [
                        'order_id'     => 'KANTIN-' . $pesanan->idpesanan . '-' . time(),
                        'gross_amount' => (int)$request->total,
                    ],
                    'customer_details' => [
                        'first_name' => $pesanan->nama,
                        'email'      => 'guest@kantin.com',
                    ],
                    'enabled_payments' => ['gopay', 'bca_va', 'bni_va', 'bri_va', 'shopeepay', 'indomaret'],
                ]);

            // Cek jika respon Midtrans gagal
            if ($response->failed()) {
                $errorBody = $response->json();
                $msg = isset($errorBody['error_messages'][0]) ? $errorBody['error_messages'][0] : 'Gagal terhubung ke Midtrans';
                throw new \Exception($msg);
            }

            $snapToken = $response->json()['token'];
            
            // 4. Update Token ke Database
            $pesanan->update(['snap_token' => $snapToken]);

            DB::commit();
            return response()->json(['snap_token' => $snapToken]);

        } catch (\Exception $e) {
            \Log::error('Checkout error: ' . $e->getMessage());
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}