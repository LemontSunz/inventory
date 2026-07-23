<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

$rows = DB::table('barang_keluar')->orderBy('id')->get();
$dates = [
    '2026-05-01',
    '2026-05-05',
    '2026-05-10',
    '2026-05-15',
    '2026-05-20',
    '2026-05-25',
    '2026-05-30',
    '2026-06-05',
    '2026-06-10',
    '2026-06-15',
    '2026-06-25',
    '2026-07-05',
];
$notes = [
    'Barang telah diterima cabang',
    'Pengiriman selesai',
    'Distribusi selesai',
    'Pengiriman sesuai jadwal',
    'Barang diterima dengan baik',
    'Pengiriman berhasil',
    'Distribusi telah diterima',
    'Barang diterima tanpa kendala',
    'Pengiriman selesai sesuai jadwal',
    'Serah terima telah selesai',
];

foreach ($rows as $index => $row) {
    $date = $dates[$index % count($dates)];
    $note = $notes[$index % count($notes)];
    DB::table('barang_keluar')->where('id', $row->id)->update([
        'tanggal_keluar' => $date,
        'status' => 'Terkirim',
        'keterangan' => $note,
    ]);
}

echo 'Updated ' . count($rows) . ' rows.';
