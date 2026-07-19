<?php

namespace Database\Seeders;

use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\IncomingGoods;
use App\Models\IncomingGoodsDetail;
use App\Models\RackLocation;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangMasukSeeder extends Seeder
{
    public function run(): void
    {
        $seedMarker = 'Seed June 2026 demo data';

        $seedItems = [
            [
                'kode_barang' => 'BD-350',
                'receiving_date' => '2026-06-03',
                'quantity_received' => 8,
                'supplier' => 'Demo Supplier A',
                'lokasi_rak' => 'R1-A',
            ],
            [
                'kode_barang' => 'BD-550',
                'receiving_date' => '2026-06-05',
                'quantity_received' => 6,
                'supplier' => 'Demo Supplier B',
                'lokasi_rak' => 'R1-B',
            ],
            [
                'kode_barang' => 'SD-338',
                'receiving_date' => '2026-06-10',
                'quantity_received' => 5,
                'supplier' => 'Demo Supplier A',
                'lokasi_rak' => 'R2-A',
            ],
            [
                'kode_barang' => 'LG-170',
                'receiving_date' => '2026-06-12',
                'quantity_received' => 10,
                'supplier' => 'Demo Supplier C',
                'lokasi_rak' => 'R2-B',
            ],
            [
                'kode_barang' => 'LG-236',
                'receiving_date' => '2026-06-18',
                'quantity_received' => 7,
                'supplier' => 'Demo Supplier C',
                'lokasi_rak' => 'R3-A',
            ],
            [
                'kode_barang' => 'IC-300',
                'receiving_date' => '2026-06-22',
                'quantity_received' => 4,
                'supplier' => 'Demo Supplier D',
                'lokasi_rak' => 'R3-B',
            ],
        ];

        DB::transaction(function () use ($seedMarker, $seedItems) {
            $user = User::whereIn('role', ['manager', 'staff_warehouse'])->first();
            if (! $user) {
                return;
            }

            $existingLegacySeeds = BarangMasuk::where('keterangan', $seedMarker)
                ->whereYear('tanggal_masuk', 2026)
                ->whereMonth('tanggal_masuk', 6)
                ->get();

            foreach ($existingLegacySeeds as $seed) {
                $barang = Barang::find($seed->barang_id);
                if ($barang) {
                    $barang->stok = max(0, ($barang->stok ?? 0) - $seed->qty_masuk);
                    $barang->save();
                }
            }

            BarangMasuk::where('keterangan', $seedMarker)
                ->whereYear('tanggal_masuk', 2026)
                ->whereMonth('tanggal_masuk', 6)
                ->delete();

            $existingIncomingSeeds = IncomingGoods::with('details')
                ->where('description', $seedMarker)
                ->whereYear('receiving_date', 2026)
                ->whereMonth('receiving_date', 6)
                ->get();

            foreach ($existingIncomingSeeds as $seed) {
                foreach ($seed->details as $detail) {
                    $barang = Barang::find($detail->item_id);
                    if ($barang) {
                        $barang->stok = max(0, ($barang->stok ?? 0) - $detail->quantity_received);
                        $barang->save();
                    }
                }
            }

            IncomingGoods::where('description', $seedMarker)
                ->whereYear('receiving_date', 2026)
                ->whereMonth('receiving_date', 6)
                ->delete();

            foreach ($seedItems as $item) {
                $barang = Barang::where('kode_barang', $item['kode_barang'])->first();
                if (! $barang) {
                    continue;
                }

                $rackLocation = RackLocation::firstOrCreate(
                    ['code' => $item['lokasi_rak']],
                    ['label' => $item['lokasi_rak'], 'description' => 'Seeded June 2026 rack location']
                );

                $incomingGoods = IncomingGoods::create([
                    'receiving_code' => IncomingGoods::generateReceivingCode(),
                    'container_number' => null,
                    'receiving_date' => $item['receiving_date'],
                    'supplier_id' => null,
                    'supplier' => $item['supplier'],
                    'delivery_order_number' => null,
                    'description' => $seedMarker,
                    'created_by' => $user->id,
                ]);

                IncomingGoodsDetail::create([
                    'incoming_goods_id' => $incomingGoods->id,
                    'item_id' => $barang->id,
                    'quantity_received' => $item['quantity_received'],
                    'rack_location_id' => $rackLocation->id,
                ]);

                $barang->stok = ($barang->stok ?? 0) + $item['quantity_received'];
                $barang->lokasi_rak = $rackLocation->code;
                $barang->save();
            }
        });
    }
}
