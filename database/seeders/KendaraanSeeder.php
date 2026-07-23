<?php

namespace Database\Seeders;

use Faker\Factory as FakerFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KendaraanSeeder extends Seeder
{
    public function run(): void
    {
        $faker = FakerFactory::create('id_ID');

        $vehicles = [
            [
                'kode_kendaraan' => 'KND0001',
                'nama_kendaraan' => 'Mitsubishi Canter FE74',
                'jenis_kendaraan' => 'CDD',
                'plat_nomor' => 'B 9123 KKM',
                'kapasitas_muatan' => 3500,
                'kilometer' => 128500,
                'tahun_pembuatan' => 2022,
                'warna' => 'Putih',
                'status' => 'Siap',
                'catatan' => 'Siap operasional untuk distribusi area Jakarta.',
            ],
            [
                'kode_kendaraan' => 'KND0002',
                'nama_kendaraan' => 'Isuzu ELF NMR71',
                'jenis_kendaraan' => 'CDD',
                'plat_nomor' => 'B 7341 TLF',
                'kapasitas_muatan' => 3200,
                'kilometer' => 142000,
                'tahun_pembuatan' => 2021,
                'warna' => 'Silver',
                'status' => 'Siap',
                'catatan' => 'Kendaraan utama untuk rute luar kota.',
            ],
            [
                'kode_kendaraan' => 'KND0003',
                'nama_kendaraan' => 'Toyota Hilux',
                'jenis_kendaraan' => 'Pickup',
                'plat_nomor' => 'B 2854 NRK',
                'kapasitas_muatan' => 1200,
                'kilometer' => 98000,
                'tahun_pembuatan' => 2020,
                'warna' => 'Hitam',
                'status' => 'Siap',
                'catatan' => 'Cocok untuk pengiriman barang cepat.',
            ],
            [
                'kode_kendaraan' => 'KND0004',
                'nama_kendaraan' => 'Hino Dutro',
                'jenis_kendaraan' => 'Fuso',
                'plat_nomor' => 'B 6418 CJD',
                'kapasitas_muatan' => 4200,
                'kilometer' => 156300,
                'tahun_pembuatan' => 2023,
                'warna' => 'Biru',
                'status' => 'Siap',
                'catatan' => 'Kendaraan berat untuk muatan besar.',
            ],
            [
                'kode_kendaraan' => 'KND0005',
                'nama_kendaraan' => 'Daihatsu Gran Max',
                'jenis_kendaraan' => 'Van',
                'plat_nomor' => 'B 7712 GRT',
                'kapasitas_muatan' => 900,
                'kilometer' => 76000,
                'tahun_pembuatan' => 2021,
                'warna' => 'Putih',
                'status' => 'Siap',
                'catatan' => $faker->sentence(8),
            ],
        ];

        foreach ($vehicles as $vehicle) {
            DB::table('kendaraan')->updateOrInsert(
                ['kode_kendaraan' => $vehicle['kode_kendaraan']],
                [
                    ...$vehicle,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
