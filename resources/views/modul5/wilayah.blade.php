@extends('layouts.main')

@section('title', 'Data Wilayah Indonesia')

@section('content')
<div class="page-header">
    <h3 class="page-title"> Rangkaian Wilayah Administrasi </h3>
</div>

<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Pilih Lokasi</h4>

                <div class="form-group">
                    <label>Level 1: Provinsi</label>
                    <select class="form-control" id="provinsi">
                        <option value="0">-- Pilih Provinsi --</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Level 2: Kota/Kabupaten</label>
                    <select class="form-control" id="kota">
                        <option value="0">-- Pilih Kota --</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Level 3: Kecamatan</label>
                    <select class="form-control" id="kecamatan">
                        <option value="0">-- Pilih Kecamatan --</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Level 4: Kelurahan</label>
                    <select class="form-control" id="kelurahan">
                        <option value="0">-- Pilih Kelurahan --</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
    // Base URL API (Menggunakan API publik agar langsung jalan, atau ganti ke local storage Anda)
    const baseUrl = "https://www.emsifa.com/api-wilayah-indonesia/api";

    const selectProv = document.getElementById('provinsi');
    const selectKota = document.getElementById('kota');
    const selectKec  = document.getElementById('kecamatan');
    const selectKel  = document.getElementById('kelurahan');

    // Load Provinsi saat halaman dibuka
    window.onload = () => {
        axios.get(`${baseUrl}/provinces.json`)
            .then(res => {
                res.data.forEach(item => {
                    let opt = new Option(item.name, item.id);
                    selectProv.add(opt);
                });
            });
    };

    // Level 1: Provinsi Change
    selectProv.onchange = () => {
        // Kosongi level 2, 3, dan 4 (Poin d)
        resetSelect(selectKota, "Kota");
        resetSelect(selectKec, "Kecamatan");
        resetSelect(selectKel, "Kelurahan");

        if (selectProv.value !== "0") {
            axios.get(`${baseUrl}/regencies/${selectProv.value}.json`)
                .then(res => {
                    res.data.forEach(item => {
                        selectKota.add(new Option(item.name, item.id));
                    });
                });
        }
    };

    // Level 2: Kota Change
    selectKota.onchange = () => {
        // Kosongi level 4 (Poin e)
        resetSelect(selectKec, "Kecamatan");
        resetSelect(selectKel, "Kelurahan");

        if (selectKota.value !== "0") {
            axios.get(`${baseUrl}/districts/${selectKota.value}.json`)
                .then(res => {
                    res.data.forEach(item => {
                        selectKec.add(new Option(item.name, item.id));
                    });
                });
        }
    };

    // Level 3: Kecamatan Change
    selectKec.onchange = () => {
        resetSelect(selectKel, "Kelurahan");

        if (selectKec.value !== "0") {
            axios.get(`${baseUrl}/villages/${selectKec.value}.json`)
                .then(res => {
                    res.data.forEach(item => {
                        selectKel.add(new Option(item.name, item.id));
                    });
                });
        }
    };

    // Fungsi pembantu untuk mengosongkan opsi (Poin f)
    function resetSelect(element, text) {
        element.innerHTML = `<option value="0">-- Pilih ${text} --</option>`;
    }
</script>
@endsection