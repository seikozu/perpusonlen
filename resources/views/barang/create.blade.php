@extends('layouts.main')

@section('title', 'Tambah Barang')

@section('content')
<div class="page-header">
    <h3 class="page-title"> Form Tambah Barang </h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('barang.index') }}">Barang</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tambah</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Input Data Barang Baru</h4>
                <p class="card-description"> Masukkan detail barang dengan lengkap </p>
                
                <form id="formBarang" class="forms-sample" action="{{ route('barang.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="nama">Nama Barang</label>
                        <input type="text" name="nama" class="form-control" id="nama" placeholder="Contoh: Kopi Susu Gula Aren" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="harga">Harga Barang (Rp)</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-gradient-primary text-white">Rp</span>
                            </div>
                            <input type="number" name="harga" class="form-control" id="harga" placeholder="Contoh: 15000" required>
                        </div>
                    </div>
                </form> <div class="mt-4">
                    <button type="button" id="btnSubmit" onclick="handleSimpan()" class="btn btn-gradient-primary me-2">
                        <span id="textTombol">
                            <i class="mdi mdi-content-save"></i> Simpan
                        </span>
                        
                        <span id="loaderTombol" style="display: none;">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Memproses...
                        </span>
                    </button>
                    <a href="{{ route('barang.index') }}" class="btn btn-light">Batal</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function handleSimpan() {
        const form = document.getElementById('formBarang');
        const btn = document.getElementById('btnSubmit');
        const text = document.getElementById('textTombol');
        const loader = document.getElementById('loaderTombol');

        // i. Cek apakah input required sudah terisi (Validasi HTML5)
        if (form.checkValidity()) {
            // iii. Jika valid, ubah jadi spinner & matikan tombol (anti double submit)
            btn.disabled = true;
            text.style.display = 'none';
            loader.style.display = 'inline-block';
            
            // Eksekusi Submit
            form.submit();
        } else {
            // ii. Jika ada yang kosong, tunjukkan peringatannya
            form.reportValidity();
        }
    }
</script>
@endsection