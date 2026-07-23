<?php

namespace Database\Seeders;

use Faker\Factory as FakerFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DriverSeeder extends Seeder
{
    public function run(): void
    {
        $faker = FakerFactory::create('id_ID');
        $cabangIds = DB::table('cabang')->pluck('id')->all();
        $vehicleIds = DB::table('kendaraan')->pluck('id')->all();

        $drivers = [
            [
                'driver_code' => 'DRV0001',
                'name' => 'Ujang Saputra',
                'phone' => '0812 3456 7890',
                'license_class' => 'SIM A',
                'license_expiry_date' => '2030-12-31',
                'status' => 'Tersedia',
                'notes' => 'Driver senior dengan pengalaman 8 tahun.',
            ],
            [
                'driver_code' => 'DRV0002',
                'name' => 'Bagas Firmansyah',
                'phone' => '0813 4567 8901',
                'license_class' => 'SIM B1',
                'license_expiry_date' => '2029-06-15',
                'status' => 'Tersedia',
                'notes' => 'Menguasai rute distribusi wilayah Jawa Barat.',
            ],
            [
                'driver_code' => 'DRV0003',
                'name' => 'Andi Setiawan',
                'phone' => '0814 5678 9012',
                'license_class' => 'SIM C',
                'license_expiry_date' => '2031-01-10',
                'status' => 'Tersedia',
                'notes' => 'Biasa menangani pengiriman skala besar.',
            ],
            [
                'driver_code' => 'DRV0004',
                'name' => 'Rudi Hartono',
                'phone' => '0815 6789 0123',
                'license_class' => 'SIM B2',
                'license_expiry_date' => '2028-11-20',
                'status' => 'Tersedia',
                'notes' => 'Berpengalaman pada cabang regional.',
            ],
            [
                'driver_code' => 'DRV0005',
                'name' => 'Dani Pratama',
                'phone' => '0816 7890 1234',
                'license_class' => 'SIM A',
                'license_expiry_date' => '2032-04-05',
                'status' => 'Tersedia',
                'notes' => $faker->sentence(8),
            ],
        ];

        foreach ($drivers as $index => $driver) {
            DB::table('drivers')->updateOrInsert(
                ['driver_code' => $driver['driver_code']],
                [
                    ...$driver,
                    'kendaraan_id' => $vehicleIds[$index % count($vehicleIds)] ?? null,
                    'cabang_id' => $cabangIds[$index % count($cabangIds)] ?? null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
