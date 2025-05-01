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
                'stok' => 2,
                'port' => 16,
                'lat' => -6.9874731,
                'long' => 107.8404948,
            ],
            [
                'name' => 'ODP B',
                'stok' => 0,
                'port' => 8,
                'lat' => -6.9922173,
                'long' => 107.8426513,
            ],
            [
                'name' => 'ODP C',
                'stok' => 0,
                'port' => 16,
                'lat' => -6.985024,
                'long' => 107.839293,
            ],
        ];

        foreach ($odps as $odp) {
            Odp::create($odp);
        }
    }
}
