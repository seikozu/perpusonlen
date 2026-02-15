@extends('layouts.app')

@section('content')

<div class="page-header">
  <h3 class="page-title">Data Kategori</h3>
</div>

<div class="row">
  <div class="col-12 grid-margin">
    <div class="card">
      <div class="card-body">

        <a href="{{ route('kategori.create') }}"
           class="btn btn-gradient-primary btn-sm mb-3">
          + Tambah Kategori
        </a>

        <div class="table-responsive">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Kategori</th>
                <th width="150">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($kategori as $k)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $k->nama_kategori }}</td>
                <td>
                  <a href="{{ route('kategori.edit', $k->id) }}"
                     class="btn btn-sm btn-warning">Edit</a>

                  <form action="{{ route('kategori.destroy', $k->id) }}"
                        method="POST"
                        style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger"
                            onclick="return confirm('Yakin hapus?')">
                      Hapus
                    </button>
                  </form>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>

      </div>
    </div>
  </div>
</div>

@endsection
