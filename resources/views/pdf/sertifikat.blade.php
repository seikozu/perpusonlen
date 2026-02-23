<!DOCTYPE html>
<html>
<head>
    <title>Sertifikat</title>
    <style>
        @page { margin: 0; }
        body { font-family: 'Arial', sans-serif; text-align: center; padding: 50px; border: 20px solid #7347c1; }
        .nama { font-size: 40px; font-weight: bold; color: #4b0082; margin: 20px 0; }
        .nomor { font-size: 14px; margin-bottom: 30px; }
    </style>
</head>
<body>
    <h1>SERTIFIKAT</h1>
    <div class="nomor">Nomor: {{ $request->nomor_sertif }}</div>
    <p>Diberikan kepada :</p>
    <div class="nama">{{ $request->nama }}</div>
    <p>Atas Partisipasinya Sebagai :</p>
    <h2>{{ $request->peran }}</h2>
    <p>Dalam acara: {{ $request->acara }}</p>
</body>
</html>