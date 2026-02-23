@extends('layouts.main')

@section('title', 'Manajemen Kategori')

@section('content')
<div class="page-header">
    <h3 class="page-title"> Manajemen Kategori </h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Kategori</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="card-title">Daftar Kategori</h4>
                    <a href="{{ url('/kategori/create') }}" class="btn btn-gradient-primary btn-fw">
                        <i class="mdi mdi-plus"></i> Tambah Kategori
                    </a>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr class="text-center">
                                <th> No </th>
                                <th> ID Kategori </th>
                                <th> Nama Kategori </th>
                                <th> Aksi </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kategori as $item)
                            <tr class="text-center">
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <label class="badge badge-light text-dark">
                                        KAT-{{ str_pad($item->id, 3, '0', STR_PAD_LEFT) }}
                                    </label>
                                </td>
                                <td>
                                    @php
                                        $colors = ['info', 'primary', 'success', 'warning', 'danger'];
                                        $color = $colors[$loop->index % count($colors)];
                                    @endphp
                                    <label class="badge badge-{{ $color }}">{{ $item->nama_kategori }}</label>
                                </td>
                                <td>
                                    <a href="{{ route('kategori.edit', $item->id) }}" class="btn btn-sm btn-light text-dark">
                                        <i class="mdi mdi-pencil"></i>
                                    </a>
                                    <form action="{{ route('kategori.destroy', $item->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-light text-danger" onclick="return confirm('Yakin hapus kategori?')">
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