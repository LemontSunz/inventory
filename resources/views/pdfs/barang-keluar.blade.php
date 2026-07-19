<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Barang Keluar</title>
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

        .status-badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
        }

        .status-dalam-perjalanan {
            background-color: #fef08a;
            color: #713f12;
        }

        .status-terkirim {
            background-color: #dcfce7;
            color: #166534;
        }

        .status-dibatalkan {
            background-color: #fee2e2;
            color: #991b1b;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="company-name">PT. KARYA MAKMUR MESINDO</div>
        <div style="font-size: 9px; color: #666;">Sistem Manajemen Logistik</div>
    </div>

    <div class="report-title">LAPORAN BARANG KELUAR</div>

    <div class="report-info">
        <div class="report-info-row">
            <strong>Tanggal Cetak:</strong> {{ $printDate->format('d/m/Y H:i:s') }}
        </div>
        @if($search)
            <div class="report-info-row">
                <strong>Pencarian:</strong> {{ $search }}
            </div>
        @endif
        @if($status)
            <div class="report-info-row">
                <strong>Status:</strong> 
                @if($status === 'in_process')
                    Dalam Proses
                @elseif($status === 'delivered')
                    Terkirim
                @elseif($status === 'cancelled')
                    Dibatalkan
                @endif
            </div>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th class="text-center">No</th>
                <th>No. Pengiriman</th>
                <th>Tanggal Keluar</th>
                <th>Cabang Tujuan</th>
                <th>Nama Barang</th>
                <th class="text-right">Qty Keluar</th>
                <th>Driver</th>
                <th>Kendaraan</th>
                <th class="text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($barangKeluars as $key => $item)
                @foreach($item->details as $idx => $detail)
                    <tr>
                        @if($idx === 0)
                            <td class="text-center" rowspan="{{ count($item->details) }}">{{ $key + 1 }}</td>
                            <td rowspan="{{ count($item->details) }}">{{ $item->nomor_pengiriman }}</td>
                            <td rowspan="{{ count($item->details) }}">{{ $item->tanggal_keluar ? \Carbon\Carbon::parse($item->tanggal_keluar)->format('d/m/Y') : '-' }}</td>
                            <td rowspan="{{ count($item->details) }}">{{ $item->cabang->nama_cabang ?? '-' }}</td>
                        @endif
                        <td>{{ $detail->item->nama_barang ?? '-' }}</td>
                        <td class="text-right">{{ $detail->jumlah_keluar }}</td>
                        @if($idx === 0)
                            <td rowspan="{{ count($item->details) }}">{{ $item->driver->name ?? '-' }}</td>
                            <td rowspan="{{ count($item->details) }}">{{ $item->kendaraan->nama_kendaraan ?? '-' }}</td>
                            <td class="text-center" rowspan="{{ count($item->details) }}">
                                <span class="status-badge status-{{ strtolower(str_replace(' ', '-', $item->status)) }}">
                                    @if($item->status === 'Dalam Perjalanan')
                                        Dalam Perjalanan
                                    @elseif($item->status === 'Terkirim')
                                        Terkirim
                                    @else
                                        {{ $item->status }}
                                    @endif
                                </span>
                            </td>
                        @endif
                    </tr>
                @endforeach
            @empty
                <tr>
                    <td colspan="9" class="text-center">Tidak ada data</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="summary">
        <div class="summary-row">Total Pengiriman: {{ count($barangKeluars) }}</div>
    </div>

    <div class="footer">
        <p>Laporan ini dihasilkan secara otomatis oleh Sistem Manajemen Logistik PT. Karya Makmur Mesindo</p>
    </div>
</body>
</html>
