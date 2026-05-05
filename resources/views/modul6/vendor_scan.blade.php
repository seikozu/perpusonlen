@extends('layouts.main')

@section('title', 'Vendor Scan QR Code')

@section('content')
<div class="page-header">
  <h3 class="page-title">Vendor Scan QR Code</h3>
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item"><a href="{{ url('/modul6/pemesanan') }}">Kantin Online</a></li>
      <li class="breadcrumb-item active" aria-current="page">Vendor Scan</li>
    </ol>
  </nav>
</div>

<div class="row">
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Scanner QR Code Customer</h4>
        <p class="card-description">Arahkan kamera ke QR code idpesanan customer. Setelah berhasil, scanner akan berhenti, bunyi beep pendek akan diputar, dan detail pesanan ditampilkan.</p>

        <div class="mb-3">
          <button id="btn-start" class="btn btn-primary mr-2">Mulai Scan</button>
          <button id="btn-stop" class="btn btn-secondary" disabled>Berhenti Scan</button>
        </div>

        <div id="scan-status" class="mb-3 text-info">Tekan tombol "Mulai Scan" untuk memulai scanner.</div>
        <div id="scan-error" class="mb-3 text-danger"></div>

        <div id="reader" style="width:100%; min-height:360px; border:1px solid #e0e0e0; border-radius: 8px; background:#f9f9f9;"></div>

        <div id="order-result" class="mt-4" style="display:none;">
          <h5>Detail Pesanan</h5>
          <div class="row">
            <div class="col-md-4 mb-3">
              <div class="card card-body">
                <strong>ID Pesanan</strong>
                <div id="order-id" class="mt-2">-</div>
              </div>
            </div>
            <div class="col-md-4 mb-3">
              <div class="card card-body">
                <strong>Status Bayar</strong>
                <div id="order-status" class="mt-2">-</div>
              </div>
            </div>
            <div class="col-md-4 mb-3">
              <div class="card card-body">
                <strong>Total Bayar</strong>
                <div id="order-total" class="mt-2">-</div>
              </div>
            </div>
          </div>
          <div class="table-responsive">
            <table class="table table-bordered">
              <thead class="thead-light">
                <tr>
                  <th>Menu</th>
                  <th>Vendor</th>
                  <th>Qty</th>
                  <th>Harga</th>
                  <th>Subtotal</th>
                </tr>
              </thead>
              <tbody id="order-items"></tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('assets/js/html5-qrcode.min.js') }}"></script>
<script>
  const scanStatus = document.getElementById('scan-status');
  const scanError = document.getElementById('scan-error');
  const btnStart = document.getElementById('btn-start');
  const btnStop = document.getElementById('btn-stop');
  const readerElementId = 'reader';
  const orderResult = document.getElementById('order-result');
  const orderIdEl = document.getElementById('order-id');
  const orderStatusEl = document.getElementById('order-status');
  const orderTotalEl = document.getElementById('order-total');
  const orderItemsEl = document.getElementById('order-items');

  let html5QrCode = null;
  let scanning = false;

  function setScanningState(value) {
    scanning = value;
    btnStart.disabled = value;
    btnStop.disabled = !value;
  }

  function setStatus(message, isError = false) {
    scanStatus.textContent = message;
    scanStatus.className = 'mb-3 ' + (isError ? 'text-danger' : 'text-info');
  }

  function setError(message) {
    scanError.textContent = message;
    setStatus(message, true);
  }

  function clearError() {
    scanError.textContent = '';
    setStatus('Tekan tombol "Mulai Scan" untuk memulai scanner.', false);
  }

  function playBeep(duration = 120, frequency = 700, volume = 0.2) {
    try {
      const audioContext = new (window.AudioContext || window.webkitAudioContext)();
      const oscillator = audioContext.createOscillator();
      const gainNode = audioContext.createGain();
      oscillator.connect(gainNode);
      gainNode.connect(audioContext.destination);
      oscillator.type = 'sine';
      oscillator.frequency.value = frequency;
      gainNode.gain.value = volume;
      oscillator.start();
      setTimeout(() => {
        oscillator.stop();
        audioContext.close();
      }, duration);
    } catch (error) {
      console.warn('Beep audio tidak tersedia:', error);
    }
  }

  function showOrder(order) {
    orderResult.style.display = 'block';
    orderIdEl.textContent = order.idpesanan;
    orderStatusEl.textContent = order.status_bayar === 1 ? 'Lunas' : 'Belum lunas';
    orderTotalEl.textContent = 'Rp ' + Number(order.total).toLocaleString('id-ID');
    orderItemsEl.innerHTML = '';
    order.items.forEach(item => {
      orderItemsEl.insertAdjacentHTML('beforeend', `
        <tr>
          <td>${item.nama_menu}</td>
          <td>${item.nama_vendor}</td>
          <td>${item.jumlah}</td>
          <td>Rp ${Number(item.harga).toLocaleString('id-ID')}</td>
          <td>Rp ${Number(item.subtotal).toLocaleString('id-ID')}</td>
        </tr>
      `);
    });
  }

  function handleScanSuccess(decodedText) {
    if (!scanning) return;

    setScanningState(false);
    setStatus('QR Code berhasil terbaca: ' + decodedText);

    if (html5QrCode) {
      html5QrCode.stop().then(() => {
        setStatus('Scanner berhenti setelah berhasil membaca QR code.');
        html5QrCode.clear();
      }).catch(error => console.warn('Gagal menghentikan scanner:', error));
    }

    playBeep();
    clearError();

    fetch(`/api/pesanan/${encodeURIComponent(decodedText)}`)
      .then(response => {
        if (!response.ok) {
          throw new Error('Pesanan tidak ditemukan.');
        }
        return response.json();
      })
      .then(data => showOrder(data))
      .catch(error => setError(error.message));
  }

  function handleScanFailure(error) {
    console.debug('Scan gagal:', error);
  }

  btnStart.addEventListener('click', async () => {
    if (scanning) return;

    html5QrCode = new Html5Qrcode(readerElementId);
    setScanningState(true);
    clearError();
    setStatus('Mencari kamera. Arahkan kamera ke QR code.');

    const config = {
      fps: 10,
      qrbox: { width: 300, height: 200 },
      formatsToSupport: [
        Html5QrcodeSupportedFormats.QR_CODE,
        Html5QrcodeSupportedFormats.CODE_128,
        Html5QrcodeSupportedFormats.EAN_13,
        Html5QrcodeSupportedFormats.EAN_8
      ]
    };

    try {
      const cameras = await Html5Qrcode.getCameras();
      if (!cameras || cameras.length === 0) {
        throw new Error('Tidak ada kamera terdeteksi. Pastikan kamera tersambung dan izinkan akses kamera.');
      }

      const backCamera = cameras.find(camera => camera.label.toLowerCase().includes('back'));
      const cameraId = backCamera ? backCamera.id : cameras[0].id;
      await html5QrCode.start(cameraId, config, handleScanSuccess, handleScanFailure);
      setStatus('Scanner aktif. Arahkan kamera ke QR code pelanggan.');
    } catch (error) {
      setScanningState(false);
      setError('Tidak dapat membuka kamera: ' + (error.message || error));
      if (html5QrCode) html5QrCode.clear();
    }
  });

  btnStop.addEventListener('click', () => {
    if (!scanning || !html5QrCode) return;

    html5QrCode.stop().then(() => {
      setScanningState(false);
      setStatus('Scanner dihentikan.');
      html5QrCode.clear();
    }).catch(error => setError('Gagal menghentikan scanner: ' + (error.message || error)));
  });
</script>
@endpush
