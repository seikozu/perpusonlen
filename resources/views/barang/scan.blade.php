@extends('layouts.main')

@section('content')
<div class="page-header">
  <h3 class="page-title"> Scanner Barcode / QR Code </h3>
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item"><a href="{{ route('barang.index') }}">Barang</a></li>
      <li class="breadcrumb-item active" aria-current="page">Scan</li>
    </ol>
  </nav>
</div>

<div class="row">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Scan Barcode Label Barang</h4>
        <p class="card-description">Arahkan kamera ke barcode atau QR code dari label barang. Setelah berhasil terbaca, scanner akan berhenti otomatis dan menampilkan detail barang.</p>

        <div class="mb-3">
          <button id="btn-start" class="btn btn-primary mr-2">Mulai Scan</button>
          <button id="btn-stop" class="btn btn-secondary" disabled>Berhenti Scan</button>
        </div>

        <div id="scan-status" class="mb-3 text-info">Tekan tombol "Mulai Scan" untuk membuka kamera.</div>
        <div id="scan-error" class="mb-3 text-danger"></div>

        <div id="reader" style="width:100%; min-height:360px; border:1px solid #e0e0e0; border-radius: 8px; background:#f9f9f9;"></div>

        <div id="result-card" class="mt-4" style="display:none;">
          <h5>Hasil Scan</h5>
          <div class="table-responsive">
            <table class="table table-bordered">
              <tbody>
                <tr>
                  <th>ID Barang</th>
                  <td id="result-id">-</td>
                </tr>
                <tr>
                  <th>Nama Barang</th>
                  <td id="result-nama">-</td>
                </tr>
                <tr>
                  <th>Harga Barang</th>
                  <td id="result-harga">-</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  const scanStatus = document.getElementById('scan-status');
  const scanError = document.getElementById('scan-error');
  const btnStart = document.getElementById('btn-start');
  const btnStop = document.getElementById('btn-stop');
  const resultCard = document.getElementById('result-card');
  const resultId = document.getElementById('result-id');
  const resultNama = document.getElementById('result-nama');
  const resultHarga = document.getElementById('result-harga');
  const readerElementId = 'reader';

  let html5QrCode = null;
  let scanning = false;
  let html5QrcodeLoaded = false;
  let html5QrcodeLoadFailed = false;
  const html5QrcodeSrc = "{{ asset('assets/js/html5-qrcode.min.js') }}";

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
    setStatus('Tekan tombol "Mulai Scan" untuk membuka kamera.', false);
  }

  function loadHtml5QrcodeLibrary() {
    return new Promise((resolve) => {
      if (html5QrcodeLoaded) {
        return resolve(true);
      }
      if (html5QrcodeLoadFailed) {
        return resolve(false);
      }

      const existing = document.querySelector(`script[src="${html5QrcodeSrc}"]`);
      if (existing) {
        existing.addEventListener('load', () => {
          html5QrcodeLoaded = true;
          resolve(true);
        });
        existing.addEventListener('error', () => {
          html5QrcodeLoadFailed = true;
          resolve(false);
        });
        return;
      }

      const script = document.createElement('script');
      script.src = html5QrcodeSrc;
      script.async = true;
      script.onload = () => {
        html5QrcodeLoaded = true;
        resolve(true);
      };
      script.onerror = () => {
        html5QrcodeLoadFailed = true;
        resolve(false);
      };
      document.body.appendChild(script);
    });
  }

  async function ensureLibraryLoaded() {
    if (html5QrcodeLoaded) {
      return true;
    }
    setStatus('Memuat library scanner...', false);
    const loaded = await loadHtml5QrcodeLibrary();
    if (!loaded) {
      setError('Library html5-qrcode gagal dimuat. Periksa koneksi internet atau gunakan browser lain.');
    }
    return loaded;
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

  function showResult(id, nama, harga) {
    resultId.textContent = id;
    resultNama.textContent = nama;
    resultHarga.textContent = harga;
    resultCard.style.display = 'block';
  }

  function clearResult() {
    resultId.textContent = '-';
    resultNama.textContent = '-';
    resultHarga.textContent = '-';
    resultCard.style.display = 'none';
  }

  function handleScanSuccess(decodedText) {
    if (!scanning) {
      return;
    }

    setScanningState(false);
    scanStatus.textContent = 'Barcode berhasil terbaca: ' + decodedText;

    if (html5QrCode) {
      html5QrCode.stop().then(() => {
        scanStatus.textContent = 'Scanner berhenti setelah berhasil membaca barcode.';
        html5QrCode.clear();
      }).catch((error) => {
        console.warn('Gagal menghentikan scanner:', error);
      });
    }

    playBeep();
    clearResult();

    fetch(`/api/barang/${encodeURIComponent(decodedText)}`)
      .then(response => {
        if (!response.ok) {
          throw new Error('Barang tidak ditemukan.');
        }
        return response.json();
      })
      .then(data => {
        showResult(decodedText, data.nama, 'Rp ' + Number(data.harga).toLocaleString('id-ID'));
      })
      .catch(error => {
        scanStatus.textContent = 'Barcode terbaca tetapi data barang tidak tersedia: ' + error.message;
      });
  }

  function handleScanFailure(error) {
    console.debug('Scan gagal:', error);
  }

  btnStart.addEventListener('click', async () => {
    if (scanning) {
      return;
    }

    const libraryReady = await ensureLibraryLoaded();
    if (!libraryReady) {
      return;
    }

    html5QrCode = new Html5Qrcode(readerElementId);
    clearResult();
    clearError();
    setScanningState(true);
    setStatus('Mencari kamera. Arahkan kamera ke barcode label...');

    const supportedFormats = window.Html5QrcodeSupportedFormats || {};
    const config = {
      fps: 10,
      qrbox: { width: 300, height: 200 }
    };

    const formats = [
      supportedFormats.QR_CODE,
      supportedFormats.CODE_128,
      supportedFormats.CODE_39,
      supportedFormats.EAN_13,
      supportedFormats.EAN_8
    ].filter(Boolean);

    if (formats.length) {
      config.formatsToSupport = formats;
    }

    try {
      const cameras = await Html5Qrcode.getCameras();
      if (!cameras || cameras.length === 0) {
        throw new Error('Tidak ada kamera yang terdeteksi. Pastikan kamera tersambung dan ijinkan akses kamera.');
      }

      const backCamera = cameras.find(camera => camera.label.toLowerCase().includes('back'));
      const cameraId = backCamera ? backCamera.id : cameras[0].id;

      await html5QrCode.start(cameraId, config, handleScanSuccess, handleScanFailure);
      setStatus('Scanner aktif. Arahkan kamera ke barcode.');
    } catch (error) {
      setScanningState(false);
      setError('Tidak dapat membuka kamera: ' + (error.message || error));
      if (html5QrCode) {
        html5QrCode.clear();
      }
    }
  });

  btnStop.addEventListener('click', () => {
    if (!scanning || !html5QrCode) {
      return;
    }

    html5QrCode.stop().then(() => {
      setScanningState(false);
      setStatus('Scanner dihentikan.');
      html5QrCode.clear();
    }).catch(error => {
      setError('Gagal menghentikan scanner: ' + (error.message || error));
    });
  });
</script>
@endpush
