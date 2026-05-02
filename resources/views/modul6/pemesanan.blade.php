@extends('layouts.main')

@section('title', 'Kantin Online - Modul 6')

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Kantin Online - Modul 6</h4>
                <p class="card-description">
                    @auth
                        Status: Login sebagai <strong>{{ Auth::user()->name }}</strong> 
                        (Role: <label class="badge badge-info">{{ ucfirst(Auth::user()->role->name ?? Auth::user()->role) }}</label>)
                    @else
                        Status: <strong>Pelanggan (Mode Tamu)</strong> 
                    @endauth
                </p>
                <hr>

                @php
                    $isGuest = !auth()->check();
                    $roleName = auth()->check() ? (Auth::user()->role->name ?? Auth::user()->role) : null;
                    $canOrder = $isGuest || $roleName == 'customer' || $roleName == 'admin';
                @endphp

                {{-- 1. BAGIAN CUSTOMER --}}
                @if($canOrder)
                <div class="customer-section mb-5">
                    <h5 class="text-primary mb-3"><i class="mdi mdi-cart-plus"></i> Form Pemesanan Makanan</h5>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>1. Pilih Vendor</label>
                                <select id="select_vendor" class="form-control" onchange="loadMenus(this.value)">
                                    <option value="0">-- Pilih Vendor --</option>
                                    @foreach($vendors as $v)
                                        <option value="{{ $v->idvendor }}">{{ $v->nama_vendor }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>2. Pilih Menu</label>
                                <select id="select_menu" class="form-control" onchange="updateDetailMenu(this)">
                                    <option value="0">-- Pilih Menu --</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Harga</label>
                                <input type="text" id="display_harga" class="form-control" readonly style="background: #f3f3f3;">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Jumlah</label>
                                <input type="number" id="input_qty" class="form-control" value="1" min="1">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-10">
                            <div class="form-group">
                                <label>Catatan Pesanan</label>
                                <input type="text" id="input_catatan" class="form-control" placeholder="Contoh: Tanpa sambal ">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label>&nbsp;</label>
                            <button type="button" id="btnTambah" class="btn btn-success btn-block" onclick="tambahKeKeranjang()" disabled>
                                Tambahkan
                            </button>
                        </div>
                    </div>

                    <div class="table-responsive mt-3">
                        <table class="table table-bordered" id="tabelPesanan">
                            <thead class="bg-light">
                                <tr>
                                    <th>Menu</th>
                                    <th>Harga</th>
                                    <th>Qty</th>
                                    <th>Subtotal</th>
                                    <th width="50">Aksi</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                            <tfoot>
                                <tr class="font-weight-bold">
                                    <td colspan="3" class="text-right">Total Bayar </td>
                                    <td colspan="2" id="total_bayar">Rp 0</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="mt-4 text-right">
                        <button type="button" id="btnCheckout" class="btn btn-primary btn-lg" onclick="prosesBayar()" disabled>
                            Bayar Sekarang 
                        </button>
                    </div>
                </div>
                @endif

                {{-- 2. BAGIAN VENDOR --}}
                @if(auth()->check() && ($roleName == 'vendor' || $roleName == 'admin'))
                <div class="vendor-section mt-5 p-4 border rounded bg-light">
                    <h5 class="text-success mb-3">
                        <i class="mdi mdi-checkbox-marked-circle-outline"></i> Monitoring Pesanan Lunas
                    </h5>
                    <div class="table-responsive">
                        <table class="table table-hover bg-white">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Waktu</th>
                                    <th>Pelanggan</th>
                                    <th>Total Bayar</th>
                                    <th>Metode</th>
                                    <th>Order ID</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pesananLunas as $lunas)
                                <tr>
                                    <td>{{ $lunas->created_at }}</td>
                                    <td><span class="badge badge-info">{{ $lunas->nama }}</span></td>
                                    <td>Rp {{ number_format($lunas->total, 0, ',', '.') }}</td>
                                    <td>{{ $lunas->payment_type ?? '-' }}</td>
                                    <td>{{ $lunas->midtrans_order_id ?? '-' }}</td>
                                </tr>
                                @empty
                                <tr><td colspan="4" class="text-center py-4 text-muted">Belum ada pesanan lunas.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Scripts --}}
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-Wa52NoSq798k25fd"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

<script>
    axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    let cart = [];
    let selectedMenuData = null;
    let grandTotal = 0;
    let currentOrderId = null;

    function loadMenus(idvendor) {
        const selectMenu = document.getElementById('select_menu');
        if(idvendor == 0) return;

        axios.get(`/modul6/get-menus/${idvendor}`)
            .then(res => {
                selectMenu.innerHTML = '<option value="0">-- Pilih Menu --</option>';
                res.data.forEach(menu => {
                    let opt = new Option(menu.nama_menu, menu.idmenu);
                    opt.dataset.harga = menu.harga;
                    selectMenu.add(opt);
                });
            });
    }

    function updateDetailMenu(el) {
        const selectedOpt = el.options[el.selectedIndex];
        if(el.value != 0) {
            selectedMenuData = {
                idmenu: el.value,
                nama: selectedOpt.text,
                harga: parseInt(selectedOpt.dataset.harga)
            };
            document.getElementById('display_harga').value = selectedMenuData.harga;
            document.getElementById('btnTambah').disabled = false;
        }
    }

    function tambahKeKeranjang() {
        const qty = parseInt(document.getElementById('input_qty').value);
        if(qty < 1) return;
        
        cart.push({
            ...selectedMenuData,
            qty: qty,
            subtotal: selectedMenuData.harga * qty,
            catatan: document.getElementById('input_catatan').value
        });
        renderTable();
        // Reset form
        document.getElementById('input_catatan').value = '';
    }

    function renderTable() {
        const tbody = document.querySelector('#tabelPesanan tbody');
        tbody.innerHTML = '';
        grandTotal = 0;
        
        cart.forEach((item, index) => {
            grandTotal += item.subtotal;
            tbody.innerHTML += `
                <tr>
                    <td>${item.nama} <br><small class="text-muted">${item.catatan}</small></td>
                    <td>${item.harga.toLocaleString('id-ID')}</td>
                    <td>${item.qty}</td>
                    <td>${item.subtotal.toLocaleString('id-ID')}</td>
                    <td><button class="btn btn-danger btn-sm" onclick="hapusItem(${index})">X</button></td>
                </tr>`;
        });
        
        document.getElementById('total_bayar').innerText = 'Rp ' + grandTotal.toLocaleString('id-ID');
        document.getElementById('btnCheckout').disabled = cart.length === 0;
    }

    function hapusItem(index) {
        cart.splice(index, 1);
        renderTable();
    }

    function prosesBayar() {
        if(grandTotal === 0) return;

        Swal.fire({
            title: 'Memproses Pesanan...',
            text: 'Mohon tunggu sebentar',
            allowOutsideClick: false,
            didOpen: () => { Swal.showLoading(); }
        });

        axios.post('/modul6/checkout', {
            total: grandTotal,
            items: cart
        })
        .then(res => {
            Swal.close();
            currentOrderId = res.data.idpesanan;
            window.snap.pay(res.data.snap_token, {
                onSuccess: function(result) {
                    axios.post('/modul6/payment-success', {
                        idpesanan: currentOrderId,
                        payment_type: result.payment_type || null
                    })
                    .then(resp => {
                        Swal.fire({
                            title: 'Pembayaran Berhasil',
                            html: `<div class="text-center mb-2">Pesanan: <strong>${resp.data.idpesanan}</strong></div>
                                   <div class="text-center mb-2">Order ID: <strong>${resp.data.midtrans_order_id}</strong></div>
                                   <div id="qrcode"></div>`,
                            width: 380,
                            didOpen: () => {
                                const qrcodeEl = document.getElementById('qrcode');
                                qrcodeEl.innerHTML = '';
                                new QRCode(qrcodeEl, {
                                    text: String(resp.data.idpesanan),
                                    width: 160,
                                    height: 160
                                });
                            }
                        }).then(() => location.reload());
                    })
                    .catch(() => {
                        Swal.fire('Gagal!', 'Pembayaran sudah berhasil tetapi proses update ke server gagal.', 'error');
                    });
                },
                onPending: function(result) {
                    Swal.fire('Pending', 'Selesaikan pembayaran segera', 'info').then(() => location.reload());
                },
                onError: function(result) {
                    Swal.fire('Gagal', 'Pembayaran Gagal', 'error');
                },
                onClose: function() {
                    Swal.fire('Info', 'Anda menutup jendela pembayaran', 'warning');
                }
            });
        })
        .catch(err => {
            Swal.close();
            const msg = err.response.data.error || 'Gagal menghubungi server';
            Swal.fire('Gagal!', msg, 'error');
        });
    }
</script>
@endsection