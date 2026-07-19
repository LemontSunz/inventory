<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Surat Jalan - {{ $barangKeluar->nomor_pengiriman ?? $barangKeluar->id }}</title>
    <style>
        @page {
            size: A4;
            margin: 20px;
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
            color: #111;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        .header-table {
            width: 100%;
            border-collapse: collapse;
        }
        .header-table td {
            vertical-align: top;
            padding: 4px;
        }
        .logo-area {
            width: 23%;
            vertical-align: top;
        }
        .logo-area img {
            width: 150px;
        }
        .company-area {
            width: 45%;
            vertical-align: top;
            padding-left: 10px;
        }
        .company-area .nama-perusahaan {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 8px;
        }
        .company-area p {
            font-size: 11px;
            margin: 2px 0;
            line-height: 1.4;
        }
        .surat-area {
            width: 32%;
            vertical-align: top;
            text-align: left;
        }
        .surat-area h2 {
            font-size: 18px;
            margin: 0 0 12px 0;
            padding: 0;
            text-align: left;
        }
        .info-surat {
            width: 100%;
            border-collapse: collapse;
        }
        .info-surat td {
            font-size: 11px;
            padding: 2px 0;
            vertical-align: top;
        }
        .info-surat td:nth-child(1) {
            width: 95px;
            font-weight: bold;
        }
        .info-surat td:nth-child(2) {
            width: 10px;
            text-align: center;
        }
        .items-table th,
        .items-table td {
            border: 1px solid #000;
            padding: 8px;
            font-size: 11px;
        }
        .items-table th {
            background: #b99700;
            color: #fff;
            font-weight: bold;
        }
        .items-table td {
            background: #fff;
        }
        .note-text {
            font-size: 11px;
            line-height: 1.4;
            margin-top: 12px;
        }
        .signature-table td {
            padding: 20px 10px 10px;
            font-size: 12px;
            vertical-align: top;
            text-align: center;
        }
        .signature-label {
            font-weight: bold;
            margin-bottom: 40px;
            display: block;
        }
        .signature-name {
            margin-top: 40px;
            font-weight: bold;
        }
        .logo {
            max-width: 100px;
            height: auto;
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

    <table class="header-table">
        <tr>
            <td class="logo-area">
                @if($logoBase64)
                    <img src="{{ $logoBase64 }}" width="150">
                @endif
            </td>
            <td class="company-area">
                <div class="nama-perusahaan">PT. Karya Makmur Mesindo</div>
                <p>Sentra Industri Terpadu 1 & 2 PIK Blok E2-8</p>
                <p>Jl. Pantai Indah Selatan Kamal Muara</p>
                <p>Penjaringan Kota Jakarta Utara</p>
                <p>Daerah Khusus Ibukota Jakarta 14470</p>
            </td>
            <td class="surat-area">
                <h2>SURAT JALAN</h2>
                <table class="info-surat">
                    <tr>
                        <td>Tanggal</td>
                        <td>:</td>
                        <td>{{ optional($barangKeluar->tanggal_keluar)->format('d M Y') ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>No. Surat Jalan</td>
                        <td>:</td>
                        <td>{{ $barangKeluar->nomor_pengiriman ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>Cabang Tujuan</td>
                        <td>:</td>
                        <td>{{ $barangKeluar->cabang->nama_cabang ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>Nama Pengemudi</td>
                        <td>:</td>
                        <td>{{ $barangKeluar->driver->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>Nama Kendaraan</td>
                        <td>:</td>
                        <td>{{ $barangKeluar->kendaraan->nama_kendaraan ?? $barangKeluar->kendaraan->kode_kendaraan ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>Plat Nomor</td>
                        <td>:</td>
                        <td>{{ $barangKeluar->kendaraan->plat_nomor ?? '-' }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <hr style="border: 1px solid #000; margin: 16px 0;">

    <table class="items-table">
        <thead>
            <tr>
                <th style="width: 6%;">No</th>
                <th style="width: 18%;">Kode Barang</th>
                <th style="width: 38%;">Nama Barang</th>
                <th style="width: 12%;">Jumlah</th>
                <th style="width: 12%;">Satuan</th>
                <th style="width: 14%;">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($barangKeluar->details as $idx => $detail)
                <tr>
                    <td>{{ $idx + 1 }}</td>
                    <td>{{ $detail->item->kode_barang ?? '-' }}</td>
                    <td>{{ $detail->item->nama_barang ?? '-' }}</td>
                    <td>{{ $detail->jumlah_keluar }}</td>
                    <td>{{ $detail->item->satuan ?? '-' }}</td>
                    <td>{{ $barangKeluar->keterangan ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table class="signature-table" style="margin-top: 40px;">
        <tr>
            <td width="50%" align="center">
                <span class="signature-label">PENERIMA,</span>
                <br><br><br><br>
                (.....................)
                <br>
                <span class="signature-name">Nama Terang</span>
            </td>
            <td width="50%" align="center">
                <span class="signature-label">PENGIRIM,</span>
                <br><br><br><br>
                (.....................)
                <br>
                <span class="signature-name">Admin Gudang</span>
            </td>
        </tr>
    </table>
</body>
</html>
