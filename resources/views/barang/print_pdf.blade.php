<!DOCTYPE html>
<html>
<head>
    <style>
        @page {
            size: 21cm 16.5cm;
            margin: 0;
        }

        html, body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            height: 16.5cm;
        }

        table {
            width: 20cm;
            height: 16cm;
            margin: 0.5cm 0.5cm 0.5cm 0.5cm;
            border-collapse: collapse;
            border-spacing: 0;
            table-layout: fixed;
            font-size: 6pt;
        }

        tr {
            height: 2cm;
        }

        td {
            width: 4cm;
            height: 2cm;
            padding: 0;
            border: none;
            box-sizing: border-box;
            vertical-align: top;
            overflow: hidden;
        }

        .card {
            width: 100%;
            height: 100%;
            max-height: 2cm;
            padding: 0.2cm 0.4cm;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            text-align: center;
            border: 0.1px solid rgba(0,0,0,0.08);
            box-sizing: border-box;
            overflow: hidden;
        }

        .barcode {
            display: block;
            margin: 0 auto 0.05cm;
            max-width: 32mm;
            max-height: 4.5mm;
            width: auto;
            height: auto;
            object-fit: contain;
        }

        .nama {
            font-size: 5.8pt;
            font-weight: bold;
            line-height: 1;
            min-height: 3.2mm;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            margin: 0;
        }

        .harga {
            font-size: 5.5pt;
            margin: 0;
            line-height: 1;
        }

        .id {
            font-size: 5pt;
            color: #444;
            margin: 0;
            line-height: 1;
        }

        .card.empty {
            border-color: transparent;
        }
    </style>
</head>
<body>
    <table>
        @php
            $cols = 5;
            $rows = 8;
            $items = collect();

            for ($i = 0; $i < $skip; $i++) {
                $items->push(null);
            }

            foreach ($barangs as $b) {
                $items->push($b);
            }

            $totalCells = $cols * $rows;
            while ($items->count() < $totalCells) {
                $items->push(null);
            }

            $chunks = $items->chunk($cols);
        @endphp

        @foreach ($chunks as $chunk)
            <tr>
                @foreach ($chunk as $item)
                    <td>
                        <div class="card{{ $item ? '' : ' empty' }}">
                            @if ($item)
                                <img src="{{ $item->barcode }}" class="barcode" alt="Barcode {{ $item->id_barang }}">
                                <div class="nama">{{ $item->nama }}</div>
                                <div class="harga">Rp {{ number_format($item->harga, 0, ',', '.') }}</div>
                                <div class="id">{{ $item->id_barang }}</div>
                            @else
                                &nbsp;
                            @endif
                        </div>
                    </td>
                @endforeach
            </tr>
        @endforeach
    </table>
</body>
</html>