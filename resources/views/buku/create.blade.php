@extends('layouts.main')

@section('title', 'Tambah Buku')

@section('content')
<div class="page-header">
    <h3 class="page-title"> Form Tambah Buku </h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/buku') }}">Buku</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tambah</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Input Data Buku Baru</h4>
                <p class="card-description"> Masukkan detail buku dengan lengkap </p>
                
                <form class="forms-sample" action="{{ url('/buku') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="kode_buku">Kode Buku</label>
                        <input type="text" class="form-control" id="kode_buku" name="kode" placeholder="Contoh: NV-01" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="judul_buku">Judul Buku</label>
                        <input type="text" class="form-control" id="judul_buku" name="judul" placeholder="Masukkan Judul Buku" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="kategori">Kategori</label>
                        <select class="form-control" id="kategori" name="id_kategori" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($kategori as $item)
                                <option value="{{ $item->id }}">{{ $item->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="penulis">Penulis</label>
                        <input type="text" class="form-control" id="penulis" name="penulis" placeholder="Nama Penulis" required>
                    </div>
                    
                    <button type="submit" class="btn btn-gradient-primary me-2">Simpan Buku</button>
                    <a href="{{ url('/buku') }}" class="btn btn-light">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection