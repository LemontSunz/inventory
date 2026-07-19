<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Barang Masuk</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            line-height: 1.4;
            color: #333;
        }

        .header {
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .company-name {
            font-size: 16px;
            font-weight: bold;
            color: #1a1a1a;
        }

        .report-title {
            font-size: 14px;
            font-weight: bold;
            text-align: center;
            margin: 15px 0;
            color: #1a1a1a;
        }

        .report-info {
            margin-bottom: 15px;
            font-size: 10px;
        }

        .report-info-row {
            margin-bottom: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table thead {
            background-color: #f0f0f0;
        }

        table th,
        table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        table th {
            font-weight: bold;
            background-color: #e8e8e8;
            font-size: 10px;
        }

        table td {
            font-size: 10px;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .summary {
            margin-top: 20px;
            border-top: 2px solid #333;
            padding-top: 10px;
        }

        .summary-row {
            margin: 5px 0;
            font-weight: bold;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 9px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="company-name">PT. KARYA MAKMUR MESINDO</div>
        <div style="font-size: 9px; color: #666;">Sistem Manajemen Logistik</div>
    </div>

    <div class="report-title">LAPORAN BARANG MASUK</div>

    <div class="report-info">
        <div class="report-info-row">
            <strong>Tanggal Cetak:</strong> {{ $printDate->format('d/m/Y H:i:s') }}
        </div>
        @if($search)
            <div class="report-info-row">
                <strong>Pencarian:</strong> {{ $search }}
            </div>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th class="text-center">No</th>
                <th>Kode Penerimaan</th>
                <th>Tanggal Penerimaan</th>
                <th>Supplier</th>
                <th>Nama Barang</th>
                <th class="text-right">Qty Diterima</th>
                <th>Lokasi Rak</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($incomingGoods as $key => $item)
                @foreach($item->details as $idx => $detail)
                    <tr>
                        @if($idx === 0)
                            <td class="text-center" rowspan="{{ count($item->details) }}">{{ $key + 1 }}</td>
                            <td rowspan="{{ count($item->details) }}">{{ $item->receiving_code }}</td>
                            <td rowspan="{{ count($item->details) }}">{{ $item->receiving_date ? \Carbon\Carbon::parse($item->receiving_date)->format('d/m/Y') : '-' }}</td>
                            <td rowspan="{{ count($item->details) }}">{{ $item->supplier ?? '-' }}</td>
                        @endif
                        <td>{{ $detail->item->nama_barang ?? '-' }}</td>
                        <td class="text-right">{{ $detail->quantity_received }}</td>
                        <td>{{ $detail->rackLocation->code ?? '-' }}</td>
                        @if($idx === 0)
                            <td rowspan="{{ count($item->details) }}">{{ $item->description ?? '-' }}</td>
                        @endif
                    </tr>
                @endforeach
            @empty
                <tr>
                    <td colspan="8" class="text-center">Tidak ada data</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="summary">
        <div class="summary-row">Total Transaksi: {{ count($incomingGoods) }}</div>
    </div>

    <div class="footer">
        <p>Laporan ini dihasilkan secara otomatis oleh Sistem Manajemen Logistik PT. Karya Makmur Mesindo</p>
    </div>
</body>
</html>
