<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        $suppliers = [
            [
                'name' => 'Guangzhou Kitchen Equipment Co., Ltd.',
                'contact_person' => 'Li Wei',
                'phone' => '+86 138 0001 0001',
                'email' => 'sales@guangzhou.example',
                'address' => 'Guangzhou, Guangdong, China',
            ],
            [
                'name' => 'Shanghai Horeca Supply Co., Ltd.',
                'contact_person' => 'Chen Ming',
                'phone' => '+86 138 0002 0002',
                'email' => 'sales@shanghai.example',
                'address' => 'Shanghai, China',
            ],
            [
                'name' => 'Qingdao Food Equipment Co., Ltd.',
                'contact_person' => 'Wang Jun',
                'phone' => '+86 138 0003 0003',
                'email' => 'sales@qingdao.example',
                'address' => 'Qingdao, Shandong, China',
            ],
            [
                'name' => 'Ningbo Commercial Kitchen Co., Ltd.',
                'contact_person' => 'Zhang Hao',
                'phone' => '+86 138 0004 0004',
                'email' => 'sales@ningbo.example',
                'address' => 'Ningbo, Zhejiang, China',
            ],
            [
                'name' => 'Shenzhen Catering Equipment Co., Ltd.',
                'contact_person' => 'Liu Qiang',
                'phone' => '+86 138 0005 0005',
                'email' => 'sales@shenzhen.example',
                'address' => 'Shenzhen, Guangdong, China',
            ],
            [
                'name' => 'Foshan Kitchen Solutions Co., Ltd.',
                'contact_person' => 'Huang Tao',
                'phone' => '+86 138 0006 0006',
                'email' => 'sales@foshan.example',
                'address' => 'Foshan, Guangdong, China',
            ],
            [
                'name' => 'Zhejiang Restaurant Equipment Co., Ltd.',
                'contact_person' => 'Sun Lei',
                'phone' => '+86 138 0007 0007',
                'email' => 'sales@zhejiang.example',
                'address' => 'Hangzhou, Zhejiang, China',
            ],
            [
                'name' => 'Seoul Kitchen Technology Co., Ltd.',
                'contact_person' => 'Park Min Seo',
                'phone' => '+82 10 2345 6789',
                'email' => 'ops@seoul.example',
                'address' => 'Seoul, Korea Selatan',
            ],
            [
                'name' => 'Busan Refrigeration Solutions Co., Ltd.',
                'contact_person' => 'Kim Ji Hoon',
                'phone' => '+82 10 2345 6790',
                'email' => 'ops@busan.example',
                'address' => 'Busan, Korea Selatan',
            ],
            [
                'name' => 'Osaka Food Machinery Co., Ltd.',
                'contact_person' => 'Sato Haruto',
                'phone' => '+81 90 1234 5678',
                'email' => 'haruto@osaka.example',
                'address' => 'Osaka, Jepang',
            ],
        ];

        foreach ($suppliers as $supplier) {
            DB::table('suppliers')->updateOrInsert(
                ['name' => $supplier['name']],
                [
                    ...$supplier,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
