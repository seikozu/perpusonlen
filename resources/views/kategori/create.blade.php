@extends('layouts.app')

@section('content')

<div class="page-header">
  <h3 class="page-title">Tambah Kategori</h3>
</div>

<div class="row">
  <div class="col-md-6 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">

        <form action="{{ route('kategori.store') }}" method="POST">
          @csrf

          <div class="form-group">
            <label>Nama Kategori</label>
            <input type="text"
                   name="nama_kategori"
                   class="form-control"
                   placeholder="Masukkan nama kategori"
                   required>
          </div>

          <button type="submit" class="btn btn-gradient-primary me-2">
            Simpan
          </button>

          <a href="{{ route('kategori.index') }}"
             class="btn btn-light">
            Kembali
          </a>
        </form>

      </div>
    </div>
  </div>
</div>

@endsection
