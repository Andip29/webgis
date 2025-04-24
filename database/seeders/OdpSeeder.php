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
                'stok' => 10,
                'port' => '8',
                'lat' => -6.9874731,
                'long' => 107.8404948,
            ],
            [
                'name' => 'ODP B',
                'stok' => 8,
                'port' => '10',
                'lat' => -6.9874731,
                'long' => 107.8404948,
            ],
            [
                'name' => 'ODP C',
                'stok' => 8,
                'port' => '10',
                'lat' => -6.985024,
                'long' => 107.839293,
            ],
        ];

        foreach ($odps as $odp) {
            Odp::create($odp);
        }
    }
}
