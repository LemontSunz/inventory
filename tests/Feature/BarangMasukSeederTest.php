<?php

namespace Tests\Feature;

use App\Models\Barang;
use App\Models\IncomingGoods;
use App\Models\User;
use Database\Seeders\BarangMasukSeeder;
use Database\Seeders\SupplierSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BarangMasukSeederTest extends TestCase
{
    use RefreshDatabase;

    protected $connectionsToTransact = [];

    public function test_barang_masuk_seeder_assigns_real_supplier_data(): void
    {
        if (config('database.default') === 'sqlite') {
            $this->markTestSkipped('This regression test requires the project database driver used in the app environment.');
        }

        $this->seed(SupplierSeeder::class);

        User::factory()->create(['role' => 'staff_warehouse']);

        foreach ([
            ['kode_barang' => 'BD-350', 'nama_barang' => 'Barang 350', 'kategori' => 'Kitchen Equipment', 'satuan' => 'pcs', 'stok' => 0, 'lokasi_rak' => 'R1-A'],
            ['kode_barang' => 'BD-550', 'nama_barang' => 'Barang 550', 'kategori' => 'Kitchen Equipment', 'satuan' => 'pcs', 'stok' => 0, 'lokasi_rak' => 'R1-B'],
            ['kode_barang' => 'SD-338', 'nama_barang' => 'Barang 338', 'kategori' => 'Refrigeration', 'satuan' => 'pcs', 'stok' => 0, 'lokasi_rak' => 'R2-A'],
            ['kode_barang' => 'LG-170', 'nama_barang' => 'Barang 170', 'kategori' => 'Small Equipment', 'satuan' => 'pcs', 'stok' => 0, 'lokasi_rak' => 'R2-B'],
            ['kode_barang' => 'LG-236', 'nama_barang' => 'Barang 236', 'kategori' => 'Storage Equipment', 'satuan' => 'pcs', 'stok' => 0, 'lokasi_rak' => 'R3-A'],
            ['kode_barang' => 'IC-300', 'nama_barang' => 'Barang 300', 'kategori' => 'Bakery Equipment', 'satuan' => 'pcs', 'stok' => 0, 'lokasi_rak' => 'R3-B'],
        ] as $barang) {
            Barang::create($barang);
        }

        $this->seed(BarangMasukSeeder::class);

        $incomingGoods = IncomingGoods::where('description', 'Seed June 2026 demo data')->get();

        $this->assertNotEmpty($incomingGoods);

        foreach ($incomingGoods as $record) {
            $this->assertNotNull($record->supplier_id);
            $this->assertNotSame('', trim((string) $record->supplier));
            $this->assertStringNotContainsString('Demo Supplier', (string) $record->supplier);
            $this->assertContains($record->supplier, [
                'Guangzhou Kitchen Equipment Co., Ltd.',
                'Shanghai Horeca Supply Co., Ltd.',
                'Qingdao Food Equipment Co., Ltd.',
                'Ningbo Commercial Kitchen Co., Ltd.',
                'Shenzhen Catering Equipment Co., Ltd.',
                'Foshan Kitchen Solutions Co., Ltd.',
                'Zhejiang Restaurant Equipment Co., Ltd.',
                'Seoul Kitchen Technology Co., Ltd.',
                'Busan Refrigeration Solutions Co., Ltd.',
                'Osaka Food Machinery Co., Ltd.',
            ]);
        }
    }
}
