@extends('layouts.main')

@section('title', 'Tambah Customer - Blob')

@section('content')
<div class="page-header">
    <h3 class="page-title">Tambah Customer (Blob)</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('customer.index') }}">Customer</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tambah Blob</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Ambil Foto Customer (Simpan ke Blob)</h4>
                <div class="row">
                    <div class="col-md-6">
                        <div id="my_camera" class="border rounded p-2"></div>
                        <button type="button" class="btn btn-primary mt-3" onClick="take_snapshot()">Ambil Foto</button>
                        <input type="hidden" name="image" class="image-tag">
                    </div>
                    <div class="col-md-6">
                        <div id="results" class="border rounded p-3 text-center">Hasil foto akan muncul di sini...</div>
                        <form action="{{ route('customer.simpan1') }}" method="POST" class="mt-3">
                            @csrf
                            <div class="form-group mb-3">
                                <input type="text" name="nama" class="form-control" placeholder="Nama Customer" required>
                            </div>
                            <input type="hidden" name="foto" class="image-tag">
                            <button class="btn btn-success">Simpan ke Database</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js"></script>
<script>
    Webcam.set({
        width: 490,
        height: 350,
        image_format: 'jpeg',
        jpeg_quality: 90
    });
    Webcam.attach('#my_camera');

    function take_snapshot() {
        Webcam.snap(function(data_uri) {
            $(".image-tag").val(data_uri);
            document.getElementById('results').innerHTML = '<img src="'+data_uri+'" class="img-fluid"/>';
        });
    }
</script>
@endpush