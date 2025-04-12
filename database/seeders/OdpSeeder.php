<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Odp;

class OdpSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $odps = [
            [
                'name' => 'ODP A',
                'jumlah_user' => 10,
                'description' => 'ODP utama wilayah A',
                'latitude' => -6.2000000,
                'longitude' => 106.8166667,
                'image' => null,
            ],
            [
                'name' => 'ODP B',
                'jumlah_user' => 15,
                'description' => 'ODP cadangan wilayah B',
                'latitude' => -6.2100000,
                'longitude' => 106.8200000,
                'image' => null,
            ],
            [
                'name' => 'ODP C',
                'jumlah_user' => 8,
                'description' => 'ODP daerah padat C',
                'latitude' => -6.1900000,
                'longitude' => 106.8300000,
                'image' => null,
            ],
        ];

        foreach ($odps as $odp) {
            Odp::create($odp);
        }
    }
}
