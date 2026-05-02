@extends('layouts.main')

@section('title', 'Data Customer')

@section('content')
<div class="page-header">
    <h3 class="page-title">Data Customer</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Customer</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title">Daftar Customer</h4>
                    <div>
                        <a href="{{ route('customer.tambah1') }}" class="btn btn-primary btn-sm">
                            <i class="mdi mdi-plus"></i> Tambah (Blob)
                        </a>
                        <a href="{{ route('customer.tambah2') }}" class="btn btn-info btn-sm">
                            <i class="mdi mdi-image"></i> Tambah (Path)
                        </a>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th>ID</th>
                                <th>Nama Customer</th>
                                <th>Foto (Blob - Tambah 1)</th>
                                <th>Foto (File Path - Tambah 2)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($customers as $c)
                                <tr>
                                    <td>{{ $c->id }}</td>
                                    <td>{{ $c->nama }}</td>
                                    <td>
                                        @if($c->foto_blob)
                                            <img src="{{ $c->foto_blob }}" width="150" class="img-fluid rounded" alt="Foto Blob">
                                        @else
                                            <span class="text-muted">No Blob Data</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($c->foto_path)
                                            <img src="{{ asset($c->foto_path) }}" width="150" class="img-fluid rounded" alt="Foto Path">
                                        @else
                                            <span class="text-muted">No File Path</span>
                                        @endif
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
