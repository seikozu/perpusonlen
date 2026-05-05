@extends('layouts.main') 

@section('content')
<div class="page-header">
  <h3 class="page-title"> Kelola Tag Barang </h3>
  <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Barang</li>
        </ol>
    </nav>
</div>

<div class="row">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Cetak Tag Harga UMKM</h4>
        
        <a href="{{ url('/barang/create') }}" class="btn btn-success btn-fw mb-3">
            <i class="mdi mdi-plus"></i> Tambah Barang
        </a>
        <a href="{{ route('barang.scan') }}" class="btn btn-info btn-fw mb-3 ml-2">
            <i class="mdi mdi-barcode-scan"></i> Scan Barcode
        </a>

        <form action="{{ route('barang.print') }}" method="POST" target="_blank">
          @csrf
          <div class="form-group row">
            <div class="col-sm-3">
              <label>Mulai Baris (Y)</label>
              <input type="number" name="start_y" class="form-control" value="1" min="1" max="8">
            </div>
            <div class="col-sm-3">
              <label>Mulai Kolom (X)</label>
              <input type="number" name="start_x" class="form-control" value="1" min="1" max="5">
            </div>
            <div class="col-sm-3 d-flex align-items-end">
              <button type="submit" class="btn btn-primary">Cetak PDF</button>
            </div>
          </div>

          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th> Pilih </th>
                  <th> ID Barang </th>
                  <th> Nama Barang </th>
                  <th> Harga </th>
                </tr>
              </thead>
              <tbody>
                @foreach($barangs as $b)
                <tr>
                  <td>
                    <input type="checkbox" name="ids[]" value="{{ $b->id_barang }}">
                  </td>
                  <td> {{ $b->id_barang }} </td>
                  <td> {{ $b->nama }} </td>
                  <td> Rp {{ number_format($b->harga, 0, ',', '.') }} </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </form>
        </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalTambah" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Barang Baru</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <form action="{{ route('barang.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Barang</label>
                        <input type="text" name="nama" class="form-control" placeholder="Nama Barang" required>
                    </div>
                    <div class="form-group">
                        <label>Harga</label>
                        <input type="number" name="harga" class="form-control" placeholder="Harga" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection