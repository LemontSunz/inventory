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
            font-family: DejaVu Sans, Arial, sans-serif;
            font-size: 11px;
            line-height: 1.4;
            color: #1f2937;
            background: #ffffff;
            padding: 18px;
        }

        .document {
            width: 100%;
        }

        .header {
            margin-bottom: 12px;
            min-height: 82px;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
        }

        .logo-cell {
            width: 80px;
            padding: 0 10px 0 0;
            vertical-align: middle;
            text-align: left;
        }

        .logo-cell img {
            width: 80px;
            height: auto;
            display: block;
        }

        .company-cell {
            vertical-align: middle;
            text-align: left;
        }

        .company-name {
            font-size: 20px;
            font-weight: bold;
            color: #111827;
            letter-spacing: 0.2px;
            text-align: left;
        }

        .company-sub {
            font-size: 11px;
            color: #4b5563;
            margin-top: 2px;
            text-align: left;
        }

        .header-line {
            height: 1px;
            background: #cbd5e1;
            margin: 8px 0 14px;
        }

        .report-title {
            font-size: 18px;
            font-weight: bold;
            text-align: center;
            margin: 6px 0 12px;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: #111827;
            padding: 8px 0;
            border-top: 1px solid #cbd5e1;
            border-bottom: 1px solid #cbd5e1;
        }

        .report-info {
            margin-bottom: 14px;
            padding: 0;
            background: transparent;
            border: 0;
            border-radius: 0;
        }

        .report-info-row {
            margin-bottom: 4px;
            color: #374151;
        }

        @page {
            margin: 18px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 16px;
            page-break-inside: auto;
        }

        thead {
            display: table-header-group;
            background-color: #f3f4f6;
        }

        tbody {
            page-break-inside: avoid;
            page-break-after: auto;
        }

        tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }

        table th,
        table td {
            border: 1px solid #d1d5db;
            padding: 7px 6px;
            text-align: left;
            font-size: 10px;
            vertical-align: top;
        }

        table th {
            font-weight: bold;
            color: #ffffff;
            background: #1f2937;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .summary {
            margin-top: 12px;
            padding-top: 10px;
            border-top: 1px solid #cbd5e1;
            font-size: 10px;
        }

        .summary-row {
            margin: 4px 0;
            font-weight: bold;
            color: #111827;
        }

        .footer {
            margin-top: 18px;
            padding-top: 10px;
            border-top: 1px solid #cbd5e1;
            text-align: center;
            font-size: 9px;
            color: #6b7280;
        }

        .footer strong {
            color: #111827;
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
    @php
        $logoPath = public_path('images/crown-horeca.jpg');
        $logoBase64 = '';

        if (file_exists($logoPath)) {
            $type = pathinfo($logoPath, PATHINFO_EXTENSION);
            $data = file_get_contents($logoPath);
            $logoBase64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        }
    @endphp

    <div class="document">
        <div class="header">
            <table class="header-table">
                <tr>
                    <td class="logo-cell" valign="middle">
                        @if($logoBase64)
                            <img src="{{ $logoBase64 }}" alt="Crown Horeca Logo">
                        @endif
                    </td>
                    <td class="company-cell" valign="middle">
                        <div class="company-name">PT. KARYA MAKMUR MESINDO</div>
                        <div class="company-sub">Warehouse Logistics Information System</div>
                    </td>
                </tr>
            </table>
            <div class="header-line"></div>
        </div>

        <div class="report-title">LAPORAN STOK BARANG</div>

        <div class="report-info">
            <div class="report-info-row">
                <strong>Tanggal Cetak:</strong> {{ $printDate->format('d/m/Y H:i:s') }}
            </div>
            <div class="report-info-row">
                <strong>Dicetak Oleh:</strong> {{ auth()->user()->name ?? 'Administrator' }}
            </div>
            @if(isset($search) && $search)
                <div class="report-info-row">
                    <strong>Pencarian:</strong> {{ $search }}
                </div>
            @endif
            @php
                $bulanFilter = request('bulan');
                $tahunFilter = request('tahun');
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
            @if($bulanFilter)
                <div class="report-info-row">
                    <strong>Filter Bulan:</strong> {{ $monthNames[(int) $bulanFilter] ?? 'Bulan tidak valid' }}
                </div>
            @endif
            @if($tahunFilter)
                <div class="report-info-row">
                    <strong>Filter Tahun:</strong> {{ $tahunFilter }}
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
            <p><strong>Dokumen ini dicetak otomatis oleh</strong></p>
            <p>Warehouse Logistics Information System</p>
            <p>PT. Karya Makmur Mesindo</p>
            <p>{{ $printDate->format('d/m/Y H:i:s') }}</p>
        </div>
    </div>
</body>
</html>
