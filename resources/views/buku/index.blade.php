@extends('layouts.main')

@section('title', 'Manajemen Buku')

@section('content')
<div class="page-header">
    <h3 class="page-title"> Manajemen Buku </h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Buku</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="card-title">Daftar Buku Tersedia</h4>
                    <a href="{{ url('/buku/create') }}" class="btn btn-gradient-primary btn-fw">
                        <i class="mdi mdi-plus"></i> Tambah Buku
                    </a>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr class="text-center">
                                <th> No </th>
                                <th> Kode </th>
                                <th> Judul Buku </th>
                                <th> Kategori </th>
                                <th> Penulis </th>
                                <th> Aksi </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($buku as $item)
                            <tr class="text-center">
                                <td>{{ $loop->iteration }}</td>
                                <td class="text-danger">{{ $item->kode }}</td>
                                <td class="text-start">{{ $item->judul }}</td>
                                <td>
                                    <label class="badge badge-info">
                                        {{ $item->kategori->nama_kategori ?? 'Umum' }}
                                    </label>
                                </td>
                                <td>{{ $item->pengarang }}</td>
                                <td>
                                    <a href="{{ route('buku.edit', $item->id) }}" class="btn btn-sm btn-light text-dark">
                                        <i class="mdi mdi-pencil"></i>
                                    </a>
                                    
                                    <form action="{{ route('buku.destroy', $item->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-light text-danger" onclick="return confirm('Yakin ingin menghapus buku ini?')">
                                            <i class="mdi mdi-trash-can"></i>
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