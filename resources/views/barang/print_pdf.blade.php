<!DOCTYPE html>
<html>
<head>
    <style>
        @page { 
            size: 210mm 148mm; 
            margin: 0; 
        }
        
        body { 
            margin: 0; 
            padding-top: 1mm;
            padding-left: 1mm; /* Sesuaikan margin fisik kertas TnJ */
            font-family: sans-serif;
        }

        .grid-container {
            width: 200mm; /* Lebar total area label (kurang lebih) */
            font-size: 0; /* Menghilangkan gap spasi antar elemen inline-block */
        }

        .label-box {
            display: inline-block; /* Lebih stabil daripada float */
            vertical-align: top;
            width: 38mm;   /* Lebar standar label TnJ 108  */
            height: 18mm;  /* Tinggi standar label TnJ 108  */
            margin: 0.2mm;   /* Jarak antar label */
            padding: 1mm;
            border: 0.1px solid #000; /* Border untuk melihat batas label, bisa dihapus */
            box-sizing: border-box;
            text-align: center;
            font-size: 7pt; /* Reset font size untuk konten */
        }

        .nama { font-weight: bold; display: block; height: 8mm; overflow: hidden; }
        .harga { font-size: 10pt; display: block; margin-top: 1mm; }
        .id { font-size: 6pt; color: #666; display: block; }
    </style>
</head>
<body>
    <div class="label-container">
        @for ($i = 0; $i < $skip; $i++)
            <div class="label-box" style="border: none;"></div>
        @endfor

        @foreach ($barangs as $b)
            <div class="label-box">
                <div style="font-size: 8pt; font-weight: bold;">{{ $b->nama }}</div>
                <div style="font-size: 10pt;">Rp {{ number_format($b->harga, 0, ',', '.') }}</div>
                <div style="font-size: 7pt;">{{ $b->id_barang }}</div>
            </div>
        @endforeach
    </div>
</body>
</html>