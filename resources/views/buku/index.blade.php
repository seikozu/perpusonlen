@extends('layouts.app')

@section('content')
<div class="page-header">
    <h3 class="page-title">Data Buku</h3>
</div>

<div class="card">
    <div class="card-body">

        <a href="{{ route('buku.create') }}" class="btn btn-primary mb-3">
            + Tambah Buku
        </a>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th>Pengarang</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($buku as $i => $b)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $b->kode }}</td>
                        <td>{{ $b->judul }}</td>
                        <td>{{ $b->kategori->nama_kategori ?? '-' }}</td>
                        <td>{{ $b->pengarang }}</td>
                        <td>
                            <a href="{{ route('buku.edit', $b->id) }}" class="btn btn-warning btn-sm">Edit</a>

                            <form action="{{ route('buku.destroy', $b->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
