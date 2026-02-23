<!DOCTYPE html>
<html>
<head>
    <title>Surat Undangan</title>
    <style>
        body { font-family: 'Times New Roman', serif; margin: 40px; line-height: 1.5; }
        .header { text-align: center; border-bottom: 4px double #000; padding-bottom: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>UNIVERSITAS AIRLANGGA</h2>
        <p>FAKULTAS VOKASI</p>
    </div>
    <p>Nomor: {{ $request->nomor_surat }}</p>
    <p>Yth. {{ $request->penerima }}</p>
    <div style="margin-top: 20px;">
        {{ $request->isi_pembuka }}
    </div>
    <p>Tempat: {{ $request->lokasi }}</p>
</body>
</html>