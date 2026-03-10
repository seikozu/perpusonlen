@extends('layouts.main')

@section('title', 'Latihan Select Kota - Modul 4')

@section('content')
<div class="page-header">
    <h3 class="page-title"> Manipulasi Select & Select2 </h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">modul 4</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-header bg-gradient-primary text-white">
                <h4 class="m-0">Select</h4>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label>Kota:</label>
                    <div class="input-group">
                        <input type="text" id="input_kota_1" class="form-control" placeholder="Masukkan nama kota">
                        <div class="input-group-append">
                            <button class="btn btn-sm btn-success" type="button" onclick="tambahKeSelectBiasa()">Tambahkan</button>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Select Kota:</label>
                    <select id="select_biasa" class="form-control" onchange="updateTerpilihBiasa()">
                        <option value="">-- Pilih Kota --</option>
                    </select>
                </div>

                <p class="text-muted">Kota Terpilih: <strong id="hasil_biasa">-</strong></p>
            </div>
        </div>
    </div>

    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-header bg-gradient-info text-white">
                <h4 class="m-0">Select 2</h4>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label>Kota:</label>
                    <div class="input-group">
                        <input type="text" id="input_kota_2" class="form-control" placeholder="Masukkan nama kota">
                        <div class="input-group-append">
                            <button class="btn btn-sm btn-success" type="button" onclick="tambahKeSelect2()">Tambahkan</button>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Select Kota (Select2):</label>
                    <select id="select_dua" class="form-control" style="width:100%">
                        <option value="">-- Pilih Kota --</option>
                    </select>
                </div>

                <p class="text-muted">Kota Terpilih: <strong id="hasil_select2">-</strong></p>
            </div>
        </div>
    </div>
</div>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        // Inisialisasi Select2
        $('#select_dua').select2();

        // Event listener onchange untuk Select2
        $('#select_dua').on('change', function() {
            $('#hasil_select2').text($(this).val() || '-');
        });
    });

    // LOGIKA CARD 1 (SELECT BIASA)
    function tambahKeSelectBiasa() {
        const input = document.getElementById('input_kota_1');
        const select = document.getElementById('select_biasa');
        
        if (input.value.trim() !== "") {
            const option = document.createElement("option");
            option.value = input.value;
            option.text = input.value;
            select.add(option);
            input.value = ""; // Kosongkan input
        }
    }

    function updateTerpilihBiasa() {
        const select = document.getElementById('select_biasa');
        document.getElementById('hasil_biasa').innerText = select.value || '-';
    }

    // LOGIKA CARD 2 (SELECT2)
    function tambahKeSelect2() {
        const input = $('#input_kota_2');
        const select = $('#select_dua');

        if (input.val().trim() !== "") {
            const newOption = new Option(input.val(), input.val(), false, false);
            select.append(newOption).trigger('change');
            input.val(""); // Kosongkan input
        }
    }
</script>
@endsection