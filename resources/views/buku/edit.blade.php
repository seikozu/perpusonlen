@extends('layouts.app')

@section('content')
<div class="page-header">
    <h3 class="page-title">Edit Buku</h3>
</div>

<div class="card">
    <div class="card-body">

        <form action="{{ route('buku.update', $buku->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label>Judul Buku</label>
                <input type="text" name="judul" class="form-control"
                       value="{{ $buku->judul }}" required>
            </div>

            <div class="mb-3">
                <label>Kategori</label>
                <select name="kategori_id" class="form-control" required>
                    @foreach ($kategori as $k)
                        <option value="{{ $k->id }}"
                            {{ $buku->kategori_id == $k->id ? 'selected' : '' }}>
                            {{ $k->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label>Pengarang</label>
                <input type="text" name="pengarang" class="form-control"
                       value="{{ $buku->pengarang }}" required>
            </div>

            <button type="submit" class="btn btn-warning">Update</button>
            <a href="{{ route('buku.index') }}" class="btn btn-secondary">Kembali</a>
        </form>

    </div>
</div>
@endsection
