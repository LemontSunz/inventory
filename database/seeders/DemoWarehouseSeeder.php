<?php

namespace Database\Seeders;

use App\Models\Barang;
use App\Models\IncomingGoods;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DemoWarehouseSeeder extends Seeder
{
    public function run(): void
    {
        $seedMarker = 'Demo Warehouse Sidang';

        DB::transaction(function () use ($seedMarker): void {
            DB::table('barang_keluar_details')
                ->whereIn('barang_keluar_id', function ($query) use ($seedMarker): void {
                    $query->from('barang_keluar')->where('keterangan', $seedMarker)->select('id');
                })
                ->delete();

            DB::table('barang_keluar')->where('keterangan', $seedMarker)->delete();

            DB::table('incoming_goods_details')
                ->whereIn('incoming_goods_id', function ($query) use ($seedMarker): void {
                    $query->from('incoming_goods')->where('description', $seedMarker)->select('id');
                })
                ->delete();

            DB::table('incoming_goods')->where('description', $seedMarker)->delete();

            $this->createCabangs();

            $this->call([
                SupplierSeeder::class,
                KendaraanSeeder::class,
                DriverSeeder::class,
            ]);

            $this->createRackLocations();
            $this->seedIncomingGoods($seedMarker);
            $this->call(BarangKeluarSeeder::class);
        });
    }

    private function createCabangs(): void
    {
        $cabangData = [
            ['kode_cabang' => 'CAB-001', 'nama_cabang' => 'Cabang Jakarta Pusat', 'kota' => 'Jakarta', 'alamat' => 'Jl. MH Thamrin No. 1'],
            ['kode_cabang' => 'CAB-002', 'nama_cabang' => 'Cabang Bandung', 'kota' => 'Bandung', 'alamat' => 'Jl. Asia Afrika No. 10'],
            ['kode_cabang' => 'CAB-003', 'nama_cabang' => 'Cabang Surabaya', 'kota' => 'Surabaya', 'alamat' => 'Jl. Raya Darmo No. 45'],
            ['kode_cabang' => 'CAB-004', 'nama_cabang' => 'Cabang Yogyakarta', 'kota' => 'Yogyakarta', 'alamat' => 'Jl. Malioboro No. 20'],
            ['kode_cabang' => 'CAB-005', 'nama_cabang' => 'Cabang Semarang', 'kota' => 'Semarang', 'alamat' => 'Jl. Pandanaran No. 33'],
        ];

        foreach ($cabangData as $cabang) {
            DB::table('cabang')->updateOrInsert(
                ['kode_cabang' => $cabang['kode_cabang']],
                [
                    ...$cabang,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }

    private function createRackLocations(): void
    {
        $categoryMapping = [
            'Refrigeration' => 'A-01',
            'Kitchen Equipment' => 'A-02',
            'Bakery Equipment' => 'B-01',
            'Small Equipment' => 'B-02',
            'Storage Equipment' => 'C-01',
        ];

        $categories = Barang::query()
            ->select('kategori')
            ->distinct()
            ->pluck('kategori')
            ->filter()
            ->values();

        foreach ($categories as $category) {
            $code = $categoryMapping[$category] ?? 'C-02';
            DB::table('rack_locations')->updateOrInsert(
                ['code' => $code],
                [
                    'label' => $category,
                    'description' => "Rak untuk {$category}",
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }

    private function seedIncomingGoods(string $seedMarker): void
    {
        $user = User::whereIn('role', ['manager', 'staff_warehouse'])->first();
        if (! $user) {
            return;
        }

        $supplierIds = DB::table('suppliers')->pluck('id')->all();
        $supplierNames = DB::table('suppliers')->pluck('name')->all();
        $supplierIdByName = DB::table('suppliers')->pluck('id', 'name')->all();
        $rackLocationIds = DB::table('rack_locations')->pluck('id')->all();
        $rackLocationByCategory = DB::table('rack_locations')
            ->select('id', 'label')
            ->get()
            ->pluck('id', 'label')
            ->all();

        $transactions = [
            ['receiving_date' => '2026-06-03', 'supplier_index' => 0, 'details' => [['kode_barang' => 'BD-350', 'quantity_received' => 18], ['kode_barang' => 'SD-338', 'quantity_received' => 14], ['kode_barang' => 'SC-71', 'quantity_received' => 12]]],
            ['receiving_date' => '2026-06-05', 'supplier_index' => 1, 'details' => [['kode_barang' => 'BD-550', 'quantity_received' => 16], ['kode_barang' => 'LG-170', 'quantity_received' => 20], ['kode_barang' => 'B10', 'quantity_received' => 10]]],
            ['receiving_date' => '2026-06-08', 'supplier_index' => 2, 'details' => [['kode_barang' => 'BD-650', 'quantity_received' => 12], ['kode_barang' => 'FW-600', 'quantity_received' => 8], ['kode_barang' => 'S10', 'quantity_received' => 9]]],
            ['receiving_date' => '2026-06-10', 'supplier_index' => 3, 'details' => [['kode_barang' => 'LG-236', 'quantity_received' => 15], ['kode_barang' => 'SC-72', 'quantity_received' => 10], ['kode_barang' => 'B15', 'quantity_received' => 11]]],
            ['receiving_date' => '2026-06-12', 'supplier_index' => 4, 'details' => [['kode_barang' => 'LG-390', 'quantity_received' => 17], ['kode_barang' => 'FRY-8L', 'quantity_received' => 9], ['kode_barang' => 'SWB-600', 'quantity_received' => 8]]],
            ['receiving_date' => '2026-06-15', 'supplier_index' => 0, 'details' => [['kode_barang' => 'ICM-1T', 'quantity_received' => 14], ['kode_barang' => 'STV-2', 'quantity_received' => 7], ['kode_barang' => 'YXY-20LS', 'quantity_received' => 6]]],
            ['receiving_date' => '2026-06-17', 'supplier_index' => 1, 'details' => [['kode_barang' => 'TC-90', 'quantity_received' => 13], ['kode_barang' => 'RQB-700-4S', 'quantity_received' => 8], ['kode_barang' => 'YXY-40AS', 'quantity_received' => 7]]],
            ['receiving_date' => '2026-06-19', 'supplier_index' => 2, 'details' => [['kode_barang' => 'CLA-90', 'quantity_received' => 11], ['kode_barang' => 'E-RCG-900', 'quantity_received' => 5], ['kode_barang' => 'C-5D', 'quantity_received' => 6]]],
            ['receiving_date' => '2026-06-21', 'supplier_index' => 3, 'details' => [['kode_barang' => 'TB150', 'quantity_received' => 16], ['kode_barang' => 'ETS-4', 'quantity_received' => 7], ['kode_barang' => 'B20', 'quantity_received' => 10]]],
            ['receiving_date' => '2026-06-24', 'supplier_index' => 4, 'details' => [['kode_barang' => 'GT500', 'quantity_received' => 12], ['kode_barang' => 'SC-5X', 'quantity_received' => 9], ['kode_barang' => 'OP-20', 'quantity_received' => 8]]],
            ['receiving_date' => '2026-06-26', 'supplier_index' => 0, 'details' => [['kode_barang' => 'BG1000', 'quantity_received' => 10], ['kode_barang' => 'EBS-100', 'quantity_received' => 6], ['kode_barang' => 'MP-16T', 'quantity_received' => 7]]],
            ['receiving_date' => '2026-06-29', 'supplier_index' => 1, 'details' => [['kode_barang' => 'G1000', 'quantity_received' => 13], ['kode_barang' => 'SC-X385', 'quantity_received' => 8], ['kode_barang' => 'X-16Q', 'quantity_received' => 6]]],
            ['receiving_date' => '2026-07-01', 'supplier_index' => 2, 'details' => [['kode_barang' => 'AQ1600', 'quantity_received' => 11], ['kode_barang' => 'BLM-2000', 'quantity_received' => 6], ['kode_barang' => 'F-16PS', 'quantity_received' => 8]]],
            ['receiving_date' => '2026-07-03', 'supplier_index' => 3, 'details' => [['kode_barang' => 'LFG2.0E', 'quantity_received' => 9], ['kode_barang' => 'SC-DE-1', 'quantity_received' => 5], ['kode_barang' => 'P-31', 'quantity_received' => 7]]],
            ['receiving_date' => '2026-07-06', 'supplier_index' => 4, 'details' => [['kode_barang' => 'VRX-1500', 'quantity_received' => 10], ['kode_barang' => 'SC-FM16A', 'quantity_received' => 6], ['kode_barang' => '189 (1 Color)', 'quantity_received' => 8]]],
            ['receiving_date' => '2026-07-08', 'supplier_index' => 0, 'details' => [['kode_barang' => 'TSI-1500', 'quantity_received' => 12], ['kode_barang' => 'TC-22', 'quantity_received' => 7], ['kode_barang' => 'Z-380', 'quantity_received' => 5]]],
            ['receiving_date' => '2026-07-10', 'supplier_index' => 1, 'details' => [['kode_barang' => 'TF-120', 'quantity_received' => 14], ['kode_barang' => 'BLA-1500', 'quantity_received' => 7], ['kode_barang' => 'MDD-36SD', 'quantity_received' => 8]]],
            ['receiving_date' => '2026-07-12', 'supplier_index' => 2, 'details' => [['kode_barang' => 'XRJ15LX2', 'quantity_received' => 10], ['kode_barang' => 'SC-EMS1', 'quantity_received' => 6], ['kode_barang' => 'YSN-Q30', 'quantity_received' => 7]]],
            ['receiving_date' => '2026-07-15', 'supplier_index' => 3, 'details' => [['kode_barang' => 'IM-55', 'quantity_received' => 13], ['kode_barang' => 'SC-H9', 'quantity_received' => 5], ['kode_barang' => 'C-10D', 'quantity_received' => 6]]],
            ['receiving_date' => '2026-07-18', 'supplier_index' => 4, 'details' => [['kode_barang' => '12JL-2', 'quantity_received' => 11], ['kode_barang' => 'E-RQP-720A', 'quantity_received' => 8], ['kode_barang' => 'TB-15', 'quantity_received' => 7]]],
        ];

        $barangCodes = collect($transactions)
            ->flatMap(fn (array $transaction): array => array_column($transaction['details'], 'kode_barang'))
            ->unique()
            ->values()
            ->all();

        $barangByCode = Barang::query()
            ->whereIn('kode_barang', $barangCodes)
            ->get()
            ->keyBy('kode_barang');

        $receivingCounter = 1;
        $chinaSupplierNames = [
            'Guangzhou Kitchen Equipment Co., Ltd.',
            'Shanghai Horeca Supply Co., Ltd.',
            'Qingdao Food Equipment Co., Ltd.',
            'Ningbo Commercial Kitchen Co., Ltd.',
            'Shenzhen Catering Equipment Co., Ltd.',
            'Foshan Kitchen Solutions Co., Ltd.',
            'Zhejiang Restaurant Equipment Co., Ltd.',
        ];
        $koreaSupplierNames = [
            'Seoul Kitchen Technology Co., Ltd.',
            'Busan Refrigeration Solutions Co., Ltd.',
        ];
        $japanSupplierNames = [
            'Osaka Food Machinery Co., Ltd.',
        ];
        $chinaCount = (int) floor(count($transactions) * 0.7);
        $koreaCount = (int) floor(count($transactions) * 0.2);

        foreach ($transactions as $index => $transaction) {
            $receivingCode = IncomingGoods::generateReceivingCode();
            $deliveryOrderNumber = 'DO-' . str_pad($receivingCounter, 4, '0', STR_PAD_LEFT);

            if ($index < $chinaCount) {
                $supplierName = $chinaSupplierNames[$index % count($chinaSupplierNames)];
            } elseif ($index < $chinaCount + $koreaCount) {
                $supplierName = $koreaSupplierNames[$index % count($koreaSupplierNames)];
            } else {
                $supplierName = $japanSupplierNames[$index % count($japanSupplierNames)];
            }

            $supplierId = $supplierIdByName[$supplierName] ?? $supplierIds[0] ?? null;

            $incomingGoodsId = DB::table('incoming_goods')->insertGetId([
                'receiving_code' => $receivingCode,
                'container_number' => 'CTR-' . str_pad($receivingCounter, 4, '0', STR_PAD_LEFT),
                'receiving_date' => $transaction['receiving_date'],
                'supplier_id' => $supplierId,
                'supplier' => $supplierName,
                'delivery_order_number' => $deliveryOrderNumber,
                'description' => $seedMarker,
                'created_by' => $user->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            foreach ($transaction['details'] as $detail) {
                $barang = $barangByCode->get($detail['kode_barang']);
                if (! $barang) {
                    continue;
                }

                $rackLocationId = $rackLocationByCategory[$barang->kategori] ?? null;
                if (! $rackLocationId && $rackLocationIds !== []) {
                    $rackLocationId = $rackLocationIds[0];
                }

                if (! $rackLocationId) {
                    continue;
                }

                DB::table('incoming_goods_details')->insert([
                    'incoming_goods_id' => $incomingGoodsId,
                    'item_id' => $barang->id,
                    'quantity_received' => $detail['quantity_received'],
                    'rack_location_id' => $rackLocationId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $barang->stok = ($barang->stok ?? 0) + $detail['quantity_received'];
                $barang->lokasi_rak = DB::table('rack_locations')->where('id', $rackLocationId)->value('code') ?? $barang->lokasi_rak;
                $barang->save();
            }

            $receivingCounter++;
        }
    }
}
