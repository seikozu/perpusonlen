@extends('layouts.main')

@section('content')
<style>
    /* Ketentuan a: Mouse pointer saat hover row */
    #tabelBarang tbody tr { cursor: pointer; }
    #tabelBarang tbody tr:hover { background-color: #f2f2f2; }
</style>

<div class="card">
    <div class="card-body">
        <h4 class="card-title">Input Data Barang (Local)</h4>
        <form id="formBarangLocal">
            <div class="form-group">
                <label>Nama Barang:</label>
                <input type="text" id="nama_barang" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Harga Barang:</label>
                <input type="number" id="harga_barang" class="form-control" required>
            </div>
            <button type="button" id="btnSubmit" onclick="tambahKeTabel()" class="btn btn-success float-right">
                <span id="textBtn">Submit</span>
                <span id="loaderBtn" style="display:none;"><span class="spinner-border spinner-border-sm"></span> Loading...</span>
            </button>
        </form>

        <div class="mt-5">
            <table class="table table-bordered" id="tabelBarang">
                <thead>
                    <tr><th>ID Barang</th><th>Nama</th><th>Harga</th></tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modalAction" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header"><h5>Detail Barang</h5></div>
            <div class="modal-body">
                <form id="formEditLocal">
                    <div class="form-group">
                        <label>ID Barang:</label>
                        <input type="text" id="edit_id" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label>Nama Barang:</label>
                        <input type="text" id="edit_nama" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Harga Barang:</label>
                        <input type="number" id="edit_harga" class="form-control" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" onclick="hapusRow()">Hapus</button>
                <button type="button" id="btnUpdate" class="btn btn-success" onclick="updateRow()">
                    <span id="textUbah">Ubah</span>
                    <span id="loaderUbah" style="display:none;"><span class="spinner-border spinner-border-sm"></span></span>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    let currentRow; // Menyimpan referensi baris yang sedang diklik

    function tambahKeTabel() {
        const form = document.getElementById('formBarangLocal');
        if (!form.checkValidity()) return form.reportValidity();

        document.getElementById('btnSubmit').disabled = true;
        document.getElementById('textBtn').style.display = 'none';
        document.getElementById('loaderBtn').style.display = 'inline-block';

        setTimeout(() => {
            const table = document.getElementById('tabelBarang').getElementsByTagName('tbody')[0];
            let newRow = table.insertRow();
            let id = Math.floor(Math.random() * 1000);
            newRow.innerHTML = `<td>${id}</td><td>${document.getElementById('nama_barang').value}</td><td>${document.getElementById('harga_barang').value}</td>`;
            
            // Ketentuan b: Klik row untuk buka modal
            newRow.onclick = function() {
                currentRow = this;
                document.getElementById('edit_id').value = this.cells[0].innerText;
                document.getElementById('edit_nama').value = this.cells[1].innerText;
                document.getElementById('edit_harga').value = this.cells[2].innerText;
                $('#modalAction').modal('show');
            };

            form.reset();
            document.getElementById('btnSubmit').disabled = false;
            document.getElementById('textBtn').style.display = 'inline-block';
            document.getElementById('loaderBtn').style.display = 'none';
        }, 500);
    }

    function updateRow() {
        const form = document.getElementById('formEditLocal');
        if (!form.checkValidity()) return form.reportValidity();

        // Ketentuan iii: Gunakan loader (Nomor 1)
        document.getElementById('btnUpdate').disabled = true;
        document.getElementById('textUbah').style.display = 'none';
        document.getElementById('loaderUbah').style.display = 'inline-block';

        setTimeout(() => {
            currentRow.cells[1].innerText = document.getElementById('edit_nama').value;
            currentRow.cells[2].innerText = document.getElementById('edit_harga').value;
            $('#modalAction').modal('hide'); // Ketentuan iv
            document.getElementById('btnUpdate').disabled = false;
            document.getElementById('textUbah').style.display = 'inline-block';
            document.getElementById('loaderUbah').style.display = 'none';
        }, 500);
    }

    function hapusRow() {
        if(confirm("Hapus baris ini?")) {
            currentRow.remove();
            $('#modalAction').modal('hide');
        }
    }
</script>
@endsection