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
                'lat' => -6.9874731,
                'long' => 107.8404948,
                'image' => null,
            ],
            [
                'name' => 'ODP B',
                'jumlah_user' => 15,
                'description' => 'ODP cadangan wilayah B',
                'lat' => -6.989220,
                'long' => 107.841031,
                'image' => null,
            ],
            [
                'name' => 'ODP C',
                'jumlah_user' => 8,
                'description' => 'ODP daerah padat C',
                'lat' => -6.985024,
                'long' => 107.839293,
                'image' => null,
            ],
        ];

        foreach ($odps as $odp) {
            Odp::create($odp);
        }
    }
}
