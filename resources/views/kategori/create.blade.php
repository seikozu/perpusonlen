@extends('layouts.main')

@section('title', 'Tambah Kategori')

@section('content')
<div class="page-header">
    <h3 class="page-title"> Form Tambah Kategori </h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/kategori') }}">Kategori</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tambah</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Input Kategori Baru</h4>
                <p class="card-description"> Tambahkan kategori buku seperti Novel, Komik, dll. </p>
                
                <form id="formKategori" class="forms-sample" action="{{ route('kategori.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="nama_kategori">Nama Kategori</label>
                        <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" placeholder="Contoh: Novel / Biografi" required>
                    </div>
                </form> 

                <div class="mt-4">
                    <button type="button" id="btnSubmit" onclick="prosesSimpanKategori()" class="btn btn-gradient-primary me-2">
                        <span id="teksTombol">Simpan</span>
                        
                        <span id="loaderTombol" style="display: none;">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Menyimpan...
                        </span>
                    </button>
                    <a href="{{ url('/kategori') }}" class="btn btn-light">Batal</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function prosesSimpanKategori() {
        const form = document.getElementById('formKategori');
        const btn = document.getElementById('btnSubmit');
        const teks = document.getElementById('teksTombol');
        const loader = document.getElementById('loaderTombol');

        // i. Cek validitas HTML5 (input required)
        if (form.checkValidity()) {
            // iii. Jika valid, tombol berubah jadi spinner & disabled
            btn.disabled = true;
            teks.style.display = 'none';
            loader.style.display = 'inline-block';
            
            // Eksekusi submit form
            form.submit();
        } else {
            // ii. Jika kosong, tunjukkan pesan error bawaan browser
            form.reportValidity();
        }
    }
</script>
@endsection