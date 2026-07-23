<?php

namespace Database\Seeders;

use App\Models\Barang;
use App\Models\BarangKeluar;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangKeluarSeeder extends Seeder
{
    public function run(): void
    {
        $cabangIds = DB::table('cabang')->pluck('id')->all();
        $driverIds = DB::table('drivers')->pluck('id')->all();
        $vehicleIds = DB::table('kendaraan')->pluck('id')->all();

        $transactions = [
            [
                'nomor_pengiriman' => 'BK-000001',
                'tanggal_keluar' => '2026-06-20',
                'status' => BarangKeluar::STATUS_DALAM_PERJALANAN,
                'keterangan' => 'Demo Warehouse Sidang',
                'details' => [
                    ['kode_barang' => 'BD-350', 'jumlah_keluar' => 8],
                    ['kode_barang' => 'SD-338', 'jumlah_keluar' => 5],
                ],
            ],
            [
                'nomor_pengiriman' => 'BK-000002',
                'tanggal_keluar' => '2026-06-24',
                'status' => BarangKeluar::STATUS_TERKIRIM,
                'keterangan' => 'Demo Warehouse Sidang',
                'details' => [
                    ['kode_barang' => 'LG-170', 'jumlah_keluar' => 6],
                    ['kode_barang' => 'SC-71', 'jumlah_keluar' => 4],
                ],
            ],
            [
                'nomor_pengiriman' => 'BK-000003',
                'tanggal_keluar' => '2026-06-27',
                'status' => BarangKeluar::STATUS_DALAM_PERJALANAN,
                'keterangan' => 'Demo Warehouse Sidang',
                'details' => [
                    ['kode_barang' => 'B10', 'jumlah_keluar' => 7],
                    ['kode_barang' => 'FW-600', 'jumlah_keluar' => 5],
                    ['kode_barang' => 'S10', 'jumlah_keluar' => 4],
                ],
            ],
            [
                'nomor_pengiriman' => 'BK-000004',
                'tanggal_keluar' => '2026-07-01',
                'status' => BarangKeluar::STATUS_TERKIRIM,
                'keterangan' => 'Demo Warehouse Sidang',
                'details' => [
                    ['kode_barang' => 'BD-550', 'jumlah_keluar' => 5],
                    ['kode_barang' => 'SC-72', 'jumlah_keluar' => 3],
                ],
            ],
            [
                'nomor_pengiriman' => 'BK-000005',
                'tanggal_keluar' => '2026-07-03',
                'status' => BarangKeluar::STATUS_DALAM_PERJALANAN,
                'keterangan' => 'Demo Warehouse Sidang',
                'details' => [
                    ['kode_barang' => 'LG-236', 'jumlah_keluar' => 7],
                    ['kode_barang' => 'B15', 'jumlah_keluar' => 6],
                ],
            ],
            [
                'nomor_pengiriman' => 'BK-000006',
                'tanggal_keluar' => '2026-07-06',
                'status' => BarangKeluar::STATUS_TERKIRIM,
                'keterangan' => 'Demo Warehouse Sidang',
                'details' => [
                    ['kode_barang' => 'TC-90', 'jumlah_keluar' => 5],
                    ['kode_barang' => 'RQB-700-4S', 'jumlah_keluar' => 4],
                    ['kode_barang' => 'YXY-20LS', 'jumlah_keluar' => 3],
                ],
            ],
            [
                'nomor_pengiriman' => 'BK-000007',
                'tanggal_keluar' => '2026-07-08',
                'status' => BarangKeluar::STATUS_DALAM_PERJALANAN,
                'keterangan' => 'Demo Warehouse Sidang',
                'details' => [
                    ['kode_barang' => 'TB150', 'jumlah_keluar' => 6],
                    ['kode_barang' => 'ETS-4', 'jumlah_keluar' => 5],
                ],
            ],
            [
                'nomor_pengiriman' => 'BK-000008',
                'tanggal_keluar' => '2026-07-10',
                'status' => BarangKeluar::STATUS_TERKIRIM,
                'keterangan' => 'Demo Warehouse Sidang',
                'details' => [
                    ['kode_barang' => 'GT500', 'jumlah_keluar' => 5],
                    ['kode_barang' => 'EBS-100', 'jumlah_keluar' => 4],
                    ['kode_barang' => 'OP-20', 'jumlah_keluar' => 3],
                ],
            ],
            [
                'nomor_pengiriman' => 'BK-000009',
                'tanggal_keluar' => '2026-07-12',
                'status' => BarangKeluar::STATUS_DALAM_PERJALANAN,
                'keterangan' => 'Demo Warehouse Sidang',
                'details' => [
                    ['kode_barang' => 'G1000', 'jumlah_keluar' => 6],
                    ['kode_barang' => 'SC-X385', 'jumlah_keluar' => 4],
                ],
            ],
            [
                'nomor_pengiriman' => 'BK-000010',
                'tanggal_keluar' => '2026-07-15',
                'status' => BarangKeluar::STATUS_TERKIRIM,
                'keterangan' => 'Demo Warehouse Sidang',
                'details' => [
                    ['kode_barang' => 'AQ1600', 'jumlah_keluar' => 5],
                    ['kode_barang' => 'BLM-2000', 'jumlah_keluar' => 4],
                ],
            ],
            [
                'nomor_pengiriman' => 'BK-000011',
                'tanggal_keluar' => '2026-07-17',
                'status' => BarangKeluar::STATUS_DALAM_PERJALANAN,
                'keterangan' => 'Demo Warehouse Sidang',
                'details' => [
                    ['kode_barang' => 'VRX-1500', 'jumlah_keluar' => 4],
                    ['kode_barang' => 'TC-22', 'jumlah_keluar' => 3],
                    ['kode_barang' => 'Z-380', 'jumlah_keluar' => 2],
                ],
            ],
            [
                'nomor_pengiriman' => 'BK-000012',
                'tanggal_keluar' => '2026-07-20',
                'status' => BarangKeluar::STATUS_TERKIRIM,
                'keterangan' => 'Demo Warehouse Sidang',
                'details' => [
                    ['kode_barang' => 'TF-120', 'jumlah_keluar' => 5],
                    ['kode_barang' => 'BLA-1500', 'jumlah_keluar' => 4],
                ],
            ],
        ];

        DB::transaction(function () use ($cabangIds, $driverIds, $vehicleIds, $transactions): void {
            $barangCodes = collect($transactions)
                ->flatMap(fn (array $transaction): array => array_column($transaction['details'], 'kode_barang'))
                ->unique()
                ->values()
                ->all();

            $barangByCode = Barang::query()
                ->whereIn('kode_barang', $barangCodes)
                ->get()
                ->keyBy('kode_barang');

            foreach ($transactions as $transaction) {
                $detailRows = [];

                foreach ($transaction['details'] as $detail) {
                    $barang = $barangByCode->get($detail['kode_barang']);
                    if (! $barang) {
                        continue;
                    }

                    if ($barang->stok < $detail['jumlah_keluar']) {
                        continue;
                    }

                    $detailRows[] = [
                        'barang' => $barang,
                        'jumlah_keluar' => $detail['jumlah_keluar'],
                    ];
                }

                if ($detailRows === []) {
                    continue;
                }

                $primaryBarang = $detailRows[0]['barang'];
                $assignedDriverId = $this->pickRandomId($driverIds);
                $assignedVehicleId = $this->pickRandomId($vehicleIds);
                $masterId = DB::table('barang_keluar')->insertGetId([
                    'barang_id' => $primaryBarang->id,
                    'cabang_id' => $this->pickRandomId($cabangIds),
                    'driver_id' => $assignedDriverId,
                    'kendaraan_id' => $assignedVehicleId,
                    'jumlah_keluar' => array_sum(array_column($detailRows, 'jumlah_keluar')),
                    'tanggal_keluar' => $transaction['tanggal_keluar'],
                    'keterangan' => $transaction['keterangan'],
                    'status' => $transaction['status'],
                    'nomor_pengiriman' => $transaction['nomor_pengiriman'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                foreach ($detailRows as $detailRow) {
                    $barang = $detailRow['barang'];

                    DB::table('barang_keluar_details')->insert([
                        'barang_keluar_id' => $masterId,
                        'barang_id' => $barang->id,
                        'jumlah_keluar' => $detailRow['jumlah_keluar'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    $barang->stok = max(0, (int) $barang->stok - $detailRow['jumlah_keluar']);
                    $barang->save();
                }

                if ($assignedDriverId !== null) {
                    DB::table('drivers')
                        ->where('id', $assignedDriverId)
                        ->update([
                            'status' => $transaction['status'] === BarangKeluar::STATUS_TERKIRIM ? 'Tersedia' : 'Sedang Bertugas',
                        ]);
                }

                if ($assignedVehicleId !== null) {
                    DB::table('kendaraan')
                        ->where('id', $assignedVehicleId)
                        ->update([
                            'status' => $transaction['status'] === BarangKeluar::STATUS_TERKIRIM ? 'Siap' : 'Dalam Perjalanan',
                        ]);
                }
            }
        });
    }

    private function pickRandomId(array $ids): ?int
    {
        if ($ids === []) {
            return null;
        }

        return (int) $ids[array_rand($ids)];
    }
}
