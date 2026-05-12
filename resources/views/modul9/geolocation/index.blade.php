@extends('layouts.main')

@section('title', 'Kunjungan Toko')

@section('content')
<div class="page-header">
    <h3 class="page-title">Kunjungan Toko</h3>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="row">
    <div class="col-lg-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Data Toko</h4>
                <p class="card-description">Simpan data awal toko sebagai titik referensi.</p>

                <form action="{{ route('modul9.kunjungan-toko.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Barcode</label>
                        <input type="text" name="barcode" class="form-control" maxlength="8" value="{{ old('barcode') }}" required>
                    </div>
                    <div class="form-group">
                        <label>Nama Toko</label>
                        <input type="text" name="nama_toko" class="form-control" maxlength="50" value="{{ old('nama_toko') }}" required>
                    </div>
                    <div class="form-group">
                        <label>Latitude</label>
                        <input type="text" name="latitude" class="form-control" value="{{ old('latitude') }}" required>
                    </div>
                    <div class="form-group">
                        <label>Longitude</label>
                        <input type="text" name="longitude" class="form-control" value="{{ old('longitude') }}" required>
                    </div>
                    <div class="form-group">
                        <label>Accuracy (meter)</label>
                        <input type="number" step="0.1" name="accuracy" class="form-control" value="{{ old('accuracy', 50) }}" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan Toko</button>
                </form>

                <div class="table-responsive mt-4">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Barcode</th>
                                <th>Nama Toko</th>
                                <th>Latitude</th>
                                <th>Longitude</th>
                                <th>Akurasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($stores as $store)
                                <tr>
                                    <td>{{ $store->barcode }}</td>
                                    <td>{{ $store->nama_toko }}</td>
                                    <td>{{ $store->latitude }}</td>
                                    <td>{{ $store->longitude }}</td>
                                    <td>{{ $store->accuracy }} m</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Belum ada data toko.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Scanner dan Verifikasi</h4>
                <p class="card-description">Scan barcode toko dan ambil lokasi sales untuk memeriksa kunjungan.</p>

                <div class="form-group">
                    <label>Barcode Toko</label>
                    <div class="input-group">
                        <input type="text" id="scan_barcode" class="form-control" maxlength="8" placeholder="Masukkan barcode toko" />
                        <button class="btn btn-secondary" type="button" onclick="fetchStore()">Scan</button>
                    </div>
                </div>

                <div class="form-group">
                    <label>Nama Toko</label>
                    <input type="text" id="store_name" class="form-control" readonly>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Latitude Toko</label>
                            <input type="text" id="store_latitude" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Longitude Toko</label>
                            <input type="text" id="store_longitude" class="form-control" readonly>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Accuracy Toko (m)</label>
                    <input type="text" id="store_accuracy" class="form-control" readonly>
                </div>

                <div class="form-group mt-4">
                    <button class="btn btn-success" type="button" onclick="getLocation()">Ambil Lokasi Sales</button>
                </div>

                <div class="form-group">
                    <label>Latitude Sales</label>
                    <input type="text" id="sales_latitude" class="form-control" readonly>
                </div>
                <div class="form-group">
                    <label>Longitude Sales</label>
                    <input type="text" id="sales_longitude" class="form-control" readonly>
                </div>
                <div class="form-group">
                    <label>Accuracy Sales (m)</label>
                    <input type="text" id="sales_accuracy" class="form-control" readonly>
                </div>
                <div class="form-group">
                    <label>Threshold Maksimum (m)</label>
                    <input type="number" id="threshold" class="form-control" value="300" min="0">
                    <small class="text-muted">Threshold efektif = threshold + akurasi toko + akurasi sales.</small>
                </div>
                <button class="btn btn-primary" type="button" onclick="submitVisit()">Submit Kunjungan</button>

                <div id="visitResult" class="mt-4"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function getAccuratePosition(targetAccuracy = 50, maxWait = 20000) {
    return new Promise((resolve, reject) => {
        let bestResult = null;
        const startTime = Date.now();

        const watchId = navigator.geolocation.watchPosition(
            (position) => {
                const acc = position.coords.accuracy;
                if (!bestResult || acc < bestResult.coords.accuracy) {
                    bestResult = position;
                }
                if (acc <= targetAccuracy) {
                    navigator.geolocation.clearWatch(watchId);
                    resolve(bestResult);
                }
                if (Date.now() - startTime >= maxWait) {
                    navigator.geolocation.clearWatch(watchId);
                    if (bestResult) resolve(bestResult);
                    else reject(new Error('Timeout, tidak dapat posisi'));
                }
            },
            (error) => reject(error),
            { enableHighAccuracy: true, maximumAge: 0, timeout: maxWait }
        );
    });
}

function haversine(lat1, lng1, lat2, lng2) {
    const R = 6371000;
    const dLat = (lat2 - lat1) * Math.PI / 180;
    const dLng = (lng2 - lng1) * Math.PI / 180;
    const a = Math.sin(dLat / 2) ** 2 + Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) * Math.sin(dLng / 2) ** 2;
    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    return R * c;
}

async function fetchStore() {
    const barcode = document.getElementById('scan_barcode').value.trim();
    const result = document.getElementById('visitResult');
    result.innerHTML = '';
    if (!barcode) {
        result.innerHTML = '<div class="alert alert-warning">Masukkan barcode toko terlebih dahulu.</div>';
        return;
    }

    try {
        const response = await fetch(`/modul9/kunjungan-toko/store/${barcode}`);
        if (!response.ok) throw new Error('Toko tidak ditemukan');
        const store = await response.json();
        document.getElementById('store_name').value = store.nama_toko;
        document.getElementById('store_latitude').value = store.latitude;
        document.getElementById('store_longitude').value = store.longitude;
        document.getElementById('store_accuracy').value = store.accuracy;
        result.innerHTML = '<div class="alert alert-success">Data toko berhasil dimuat.</div>';
    } catch (error) {
        result.innerHTML = `<div class="alert alert-danger">${error.message}</div>`;
    }
}

async function getLocation() {
    const result = document.getElementById('visitResult');
    result.innerHTML = '<div class="alert alert-info">Mencari lokasi terbaik...</div>';
    try {
        const pos = await getAccuratePosition(50, 20000);
        document.getElementById('sales_latitude').value = pos.coords.latitude;
        document.getElementById('sales_longitude').value = pos.coords.longitude;
        document.getElementById('sales_accuracy').value = pos.coords.accuracy;
        result.innerHTML = '<div class="alert alert-success">Lokasi sales berhasil diambil.</div>';
    } catch (error) {
        result.innerHTML = `<div class="alert alert-danger">${error.message}</div>`;
    }
}

async function submitVisit() {
    const result = document.getElementById('visitResult');
    result.innerHTML = '';
    const barcode = document.getElementById('scan_barcode').value.trim();
    const salesLat = parseFloat(document.getElementById('sales_latitude').value);
    const salesLng = parseFloat(document.getElementById('sales_longitude').value);
    const salesAcc = parseFloat(document.getElementById('sales_accuracy').value);
    const threshold = parseFloat(document.getElementById('threshold').value);

    if (!barcode || Number.isNaN(salesLat) || Number.isNaN(salesLng) || Number.isNaN(salesAcc)) {
        result.innerHTML = '<div class="alert alert-warning">Pastikan barcode toko, lokasi sales, dan akurasi sudah terisi.</div>';
        return;
    }

    try {
        const response = await fetch('/modul9/kunjungan-toko/check', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                barcode,
                sales_latitude: salesLat,
                sales_longitude: salesLng,
                sales_accuracy: salesAcc,
                threshold: threshold || 300,
            })
        });

        const data = await response.json();
        if (!response.ok) {
            const message = data.message || (data.errors ? Object.values(data.errors).flat().join('<br>') : 'Terjadi kesalahan.');
            result.innerHTML = `<div class="alert alert-danger">${message}</div>`;
            return;
        }

        const store = data.store;
        result.innerHTML = `
            <div class="alert ${data.accepted ? 'alert-success' : 'alert-danger'}">
                <strong>${data.accepted ? 'DITERIMA' : 'DITOLAK'}</strong><br>
                Jarak aktual: ${data.distance.toFixed(2)} m<br>
                Threshold efektif: ${data.effectiveThreshold.toFixed(2)} m<br>
                Toko: ${store.nama_toko} (${store.barcode})
            </div>
        `;
    } catch (error) {
        result.innerHTML = `<div class="alert alert-danger">${error.message}</div>`;
    }
}
</script>
@endpush
