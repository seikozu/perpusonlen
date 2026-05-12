<?php

namespace App\Http\Controllers;

use App\Models\LokasiToko;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GeolocationController extends Controller
{
    public function index()
    {
        $stores = LokasiToko::orderBy('nama_toko')->get();
        return view('modul9.geolocation.index', compact('stores'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'barcode' => 'required|string|max:8',
            'nama_toko' => 'required|string|max:50',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'accuracy' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        LokasiToko::updateOrCreate(
            ['barcode' => $request->barcode],
            [
                'nama_toko' => $request->nama_toko,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'accuracy' => $request->accuracy,
            ]
        );

        return redirect()->route('modul9.kunjungan-toko')
            ->with('success', 'Data toko berhasil disimpan.');
    }

    public function showStore($barcode)
    {
        $store = LokasiToko::find($barcode);
        if (!$store) {
            return response()->json(['message' => 'Toko tidak ditemukan'], 404);
        }
        return response()->json($store);
    }

    public function checkVisit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'barcode' => 'required|string|max:8',
            'sales_latitude' => 'required|numeric',
            'sales_longitude' => 'required|numeric',
            'sales_accuracy' => 'required|numeric|min:0',
            'threshold' => 'nullable|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $store = LokasiToko::find($request->barcode);
        if (!$store) {
            return response()->json(['message' => 'Toko tidak ditemukan'], 404);
        }

        $threshold = $request->input('threshold', 300);
        $distance = $this->haversine(
            $store->latitude,
            $store->longitude,
            $request->sales_latitude,
            $request->sales_longitude
        );

        $effectiveThreshold = $threshold + $store->accuracy + $request->sales_accuracy;
        $accepted = $distance <= $effectiveThreshold;

        return response()->json([
            'accepted' => $accepted,
            'distance' => round($distance, 2),
            'effectiveThreshold' => round($effectiveThreshold, 2),
            'threshold' => $threshold,
            'store' => $store,
        ]);
    }

    private function haversine($lat1, $lng1, $lat2, $lng2)
    {
        $R = 6371000;
        $dLat = deg2rad($lat2 - $lat1);
        $dLng = deg2rad($lng2 - $lng1);
        $a = pow(sin($dLat / 2), 2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * pow(sin($dLng / 2), 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        return $R * $c;
    }
}
