<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Stok Barang</title>
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

        .status-kritis {
            color: #dc2626;
            font-weight: bold;
        }

        .status-menipis {
            color: #f59e0b;
            font-weight: bold;
        }

        .status-aman {
            color: #10b981;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="company-name">PT. KARYA MAKMUR MESINDO</div>
        <div style="font-size: 9px; color: #666;">Sistem Manajemen Logistik</div>
    </div>

    <div class="report-title">LAPORAN STOK BARANG</div>

    <div class="report-info">
        <div class="report-info-row">
            <strong>Tanggal Cetak:</strong> {{ $printDate->format('d/m/Y H:i:s') }}
        </div>
        @if($search)
            <div class="report-info-row">
                <strong>Pencarian:</strong> {{ $search }}
            </div>
        @endif
        @if($bulan || $tahun)
            @php
                $monthNames = [
                    1 => 'Januari',
                    2 => 'Februari',
                    3 => 'Maret',
                    4 => 'April',
                    5 => 'Mei',
                    6 => 'Juni',
                    7 => 'Juli',
                    8 => 'Agustus',
                    9 => 'September',
                    10 => 'Oktober',
                    11 => 'November',
                    12 => 'Desember',
                ];
            @endphp
            <div class="report-info-row">
                <strong>Periode:</strong>
                @if($bulan)
                    {{ $monthNames[(int) $bulan] ?? 'Bulan tidak valid' }}
                @endif
                @if($tahun)
                    {{ $bulan ? ' ' : '' }}{{ $tahun }}
                @endif
            </div>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th class="text-center">No</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th class="text-right">Stok Saat Ini</th>
                <th class="text-right">Total Masuk</th>
                <th class="text-right">Total Keluar</th>
                <th class="text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($laporans as $key => $laporan)
                @php
                    $stok = $laporan->stok_saat_ini;
                    if ($stok <= 5) {
                        $status = 'Kritis';
                        $statusClass = 'status-kritis';
                    } elseif ($stok <= 20) {
                        $status = 'Menipis';
                        $statusClass = 'status-menipis';
                    } else {
                        $status = 'Aman';
                        $statusClass = 'status-aman';
                    }
                @endphp
                <tr>
                    <td class="text-center">{{ $key + 1 }}</td>
                    <td>{{ $laporan->kode_barang }}</td>
                    <td>{{ $laporan->nama_barang }}</td>
                    <td class="text-right">{{ number_format($laporan->stok_saat_ini, 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($laporan->total_barang_masuk, 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($laporan->total_barang_keluar, 0, ',', '.') }}</td>
                    <td class="text-center"><span class="{{ $statusClass }}">{{ $status }}</span></td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Tidak ada data</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="summary">
        <div class="summary-row">Total Data: {{ count($laporans) }}</div>
        <div class="summary-row">Total Stok: {{ number_format($totalStok, 0, ',', '.') }} Unit</div>
    </div>

    <div class="footer">
        <p>Laporan ini dihasilkan secara otomatis oleh Sistem Manajemen Logistik PT. Karya Makmur Mesindo</p>
    </div>
</body>
</html>
