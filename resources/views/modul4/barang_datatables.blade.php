@extends('layouts.main')

@section('content')
<style>
    #myDataTable tbody tr { cursor: pointer; }
</style>

<div class="card">
    <div class="card-body">
        <h4 class="card-title">Input Data Barang (DataTables)</h4>
        <form id="formBarangDT">
            <div class="form-group"><label>Nama:</label><input type="text" id="dt_nama" class="form-control" required></div>
            <div class="form-group"><label>Harga:</label><input type="number" id="dt_harga" class="form-control" required></div>
            <button type="button" id="btnSubmitDT" onclick="tambahKeDT()" class="btn btn-primary float-right">Submit</button>
        </form>

        <div class="mt-5">
            <table class="table table-striped" id="myDataTable">
                <thead><tr><th>ID</th><th>Nama</th><th>Harga</th></tr></thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modalDT" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header"><h5>Edit DataTables Row</h5></div>
            <div class="modal-body">
                <form id="formEditDT">
                    <input type="text" id="ed_dt_id" class="form-control mb-2" readonly>
                    <input type="text" id="ed_dt_nama" class="form-control mb-2" required>
                    <input type="number" id="ed_dt_harga" class="form-control mb-2" required>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" onclick="hapusDT()">Hapus</button>
                <button type="button" class="btn btn-success" onclick="updateDT()">Ubah</button>
            </div>
        </div>
    </div>
</div>

<script>
    let dtTable, selectedRow;

    $(document).ready(function() {
        dtTable = $('#myDataTable').DataTable();

        // Event click row pada DataTables
        $('#myDataTable tbody').on('click', 'tr', function () {
            selectedRow = dtTable.row(this);
            let data = selectedRow.data();
            if(data) {
                $('#ed_dt_id').val(data[0]);
                $('#ed_dt_nama').val(data[1]);
                $('#ed_dt_harga').val(data[2]);
                $('#modalDT').modal('show');
            }
        });
    });

    function tambahKeDT() {
        const form = document.getElementById('formBarangDT');
        if (!form.checkValidity()) return form.reportValidity();
        
        dtTable.row.add([
            'ID-' + Math.floor(Math.random() * 1000),
            $('#dt_nama').val(),
            $('#dt_harga').val()
        ]).draw();
        form.reset();
    }

    function updateDT() {
        const form = document.getElementById('formEditDT');
        if (!form.checkValidity()) return form.reportValidity();

        // Update data di DataTables API agar fitur search/sort tetap jalan
        selectedRow.data([
            $('#ed_dt_id').val(),
            $('#ed_dt_nama').val(),
            $('#ed_dt_harga').val()
        ]).draw();
        
        $('#modalDT').modal('hide');
    }

    function hapusDT() {
        selectedRow.remove().draw();
        $('#modalDT').modal('hide');
    }
</script>
@endsection