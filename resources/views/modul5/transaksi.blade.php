@extends('layouts.main')

@section('title', 'Point of Sales (POS)')

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Halaman Kasir (POS)</h4>
                <hr>
                
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Kode Barang</label>
                            <input type="text" id="kode_barang" class="form-control" placeholder="Tekan Enter..." autocomplete="off">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Nama Barang</label>
                            <input type="text" id="nama_barang" class="form-control" readonly style="background: #e9ecef;">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Harga</label>
                            <input type="number" id="harga_barang" class="form-control" readonly style="background: #e9ecef;">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Jumlah</label>
                            <input type="number" id="jumlah" class="form-control" value="1" min="1">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label>&nbsp;</label>
                        <button type="button" id="btnTambahkan" class="btn btn-success btn-block" disabled onclick="tambahKeTable()">
                            Tambahkan
                        </button>
                    </div>
                </div>

                <div class="table-responsive mt-4">
                    <table class="table table-bordered" id="tabelPOS">
                        <thead class="bg-light">
                            <tr>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Harga</th>
                                <th width="150">Jumlah</th>
                                <th>Subtotal</th>
                                <th width="50">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="4" class="text-right">Total</th>
                                <th colspan="2" id="grandTotal">Rp 0</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="mt-4 text-right">
                    <button type="button" id="btnBayar" class="btn btn-primary btn-lg" onclick="simpanTransaksi()">
                        <span id="textBayar">Bayar</span>
                        <span id="loaderBayar" style="display:none;">
                            <span class="spinner-border spinner-border-sm"></span> Memproses...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    let keranjang = [];

    // b. Cari Barang via Enter
    document.getElementById('kode_barang').addEventListener('keypress', function (e) {
        if (e.key === 'Enter') {
            cariBarang(this.value);
        }
    });

    function cariBarang(kode) {
        // Gunakan endpoint API yang mengarah ke Database Barang Anda
        axios.get(`/api/barang/${kode}`)
            .then(res => {
                if(res.data) {
                    document.getElementById('nama_barang').value = res.data.nama;
                    document.getElementById('harga_barang').value = res.data.harga;
                    document.getElementById('btnTambahkan').disabled = false; // d. Aktifkan button
                } else {
                    Swal.fire('Error', 'Barang tidak ditemukan!', 'error');
                    resetInput();
                }
            })
            .catch(err => {
                Swal.fire('Error', 'Kode barang salah!', 'error');
                resetInput();
            });
    }

    function tambahKeTable() {
        const kode = document.getElementById('kode_barang').value;
        const nama = document.getElementById('nama_barang').value;
        const harga = parseInt(document.getElementById('harga_barang').value);
        const qty = parseInt(document.getElementById('jumlah').value);

        // f. Cek jika barang sudah ada di tabel
        let existing = keranjang.find(item => item.kode === kode);
        if (existing) {
            existing.qty += qty;
            existing.subtotal = existing.qty * existing.harga;
        } else {
            keranjang.push({
                kode, nama, harga, qty, subtotal: harga * qty
            });
        }
        
        renderTable();
        resetInput();
    }

    function renderTable() {
        const tbody = document.querySelector('#tabelPOS tbody');
        tbody.innerHTML = '';
        let total = 0;

        keranjang.forEach((item, index) => {
            total += item.subtotal;
            tbody.innerHTML += `
                <tr>
                    <td>${item.kode}</td>
                    <td>${item.nama}</td>
                    <td>${item.harga}</td>
                    <td>
                        <input type="number" class="form-control form-control-sm" value="${item.qty}" 
                        onchange="updateQty(${index}, this.value)">
                    </td>
                    <td>${item.subtotal}</td>
                    <td><button class="btn btn-danger btn-sm" onclick="hapusItem(${index})">X</button></td>
                </tr>
            `;
        });

        document.getElementById('grandTotal').innerText = 'Rp ' + total.toLocaleString('id-ID');
        document.getElementById('btnBayar').disabled = keranjang.length === 0;
    }

    function updateQty(index, val) {
        if(val < 1) val = 1;
        keranjang[index].qty = parseInt(val);
        keranjang[index].subtotal = keranjang[index].qty * keranjang[index].harga;
        renderTable();
    }

    function hapusItem(index) {
        keranjang.splice(index, 1);
        renderTable();
    }

    function resetInput() {
        document.getElementById('kode_barang').value = '';
        document.getElementById('nama_barang').value = '';
        document.getElementById('harga_barang').value = '';
        document.getElementById('jumlah').value = 1;
        document.getElementById('btnTambahkan').disabled = true;
        document.getElementById('kode_barang').focus();
    }

    // i, j, k, l. Simpan Transaksi Master-Detail
    function simpanTransaksi() {
        const btn = document.getElementById('btnBayar');
        btn.disabled = true;
        document.getElementById('textBayar').style.display = 'none';
        document.getElementById('loaderBayar').style.display = 'inline-block';

        axios.post('/api/transaksi/simpan', {
            total: keranjang.reduce((a, b) => a + b.subtotal, 0),
            items: keranjang
        })
        .then(res => {
            Swal.fire('Berhasil!', 'Pembayaran transaksi berhasil disimpan', 'success');
            keranjang = [];
            renderTable();
            btn.disabled = false;
            document.getElementById('textBayar').style.display = 'inline-block';
            document.getElementById('loaderBayar').style.display = 'none';
        })
        .catch(err => {
            Swal.fire('Gagal', 'Terjadi kesalahan sistem', 'error');
            btn.disabled = false;
            document.getElementById('textBayar').style.display = 'inline-block';
            document.getElementById('loaderBayar').style.display = 'none';
        });
    }
</script>
@endsection