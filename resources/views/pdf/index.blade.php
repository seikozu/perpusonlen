@extends('layouts.main')

@section('content')
<div class="row">
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Input Data Sertifikat (Landscape)</h4>
                <form action="{{ url('/generate-sertifikat') }}" method="POST" target="_blank">
                    @csrf
                    <div class="form-group">
                        <label>Nomor Sertifikat</label>
                        <input type="text" name="nomor_sertif" class="form-control" placeholder="Contoh: 3353/B/UN3.FIKKIA/2025" required>
                    </div>
                    <div class="form-group">
                        <label>Nama Lengkap Penerima</label>
                        <input type="text" name="nama" class="form-control" placeholder="Nama yang akan muncul di tengah" required>
                    </div>
                    <div class="form-group">
                        <label>Partisipasi Sebagai</label>
                        <input type="text" name="peran" class="form-control" placeholder="Contoh: Peserta Terbaik / Pemateri" required>
                    </div>
                    <div class="form-group">
                        <label>Nama Acara</label>
                        <input type="text" name="acara" class="form-control" placeholder="Contoh: Seminar Nasional Kesehatan">
                    </div>
                    <button type="submit" class="btn btn-gradient-primary">Cetak Sertifikat</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Input Data Undangan (Portrait)</h4>
                <form action="{{ url('/generate-pengumuman') }}" method="POST" target="_blank">
                    @csrf
                    <div class="form-group">
                        <label>Nomor Surat</label>
                        <input type="text" name="nomor_surat" class="form-control" placeholder="Contoh: 556/B/DST/UN3.FV/2026" required>
                    </div>
                    <div class="form-group">
                        <label>Tanggal Surat</label>
                        <input type="text" name="tanggal_surat" class="form-control" placeholder="Contoh: 23 Februari 2026">
                    </div>
                    <div class="form-group">
                        <label>Penerima (Yth.)</label>
                        <input type="text" name="penerima" class="form-control" placeholder="Contoh: Para Wakil Dekan">
                    </div>
                    <div class="form-group">
                        <label>Keperluan / Isi Ringkas</label>
                        <textarea name="isi_pembuka" class="form-control" rows="3" placeholder="Contoh: Dalam rangka mempererat tali silaturahmi..."></textarea>
                    </div>
                    <div class="form-group">
                        <label>Tempat / Lokasi</label>
                        <input type="text" name="lokasi" class="form-control" placeholder="Contoh: Aula Gedung A Lt.3 Fakultas Vokasi">
                    </div>
                    <button type="submit" class="btn btn-gradient-info">Cetak Surat Undangan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection