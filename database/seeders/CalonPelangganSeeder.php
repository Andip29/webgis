<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CalonPelanggan;

class CalonPelangganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $calonPelanggans = [
            [
                'name' => 'Andi Wijaya',
                'email' => 'andi@example.com',
                'no_telp' => '081234567890',
                'alamat' => 'Jl. Merdeka No. 1, Bandung',
                'lat' => -6.989518,
                'long' => 107.845183,
            ],
            [
                'name' => 'Siti Aminah',
                'email' => 'siti@example.com',
                'no_telp' => '081298765432',
                'alamat' => 'Jl. Cihampelas No. 10, Bandung',
                'lat' => -6.989518,
                'long' => 107.838617,
            ],
            [
                'name' => 'Budi Santoso',
                'email' => 'budi@example.com',
                'no_telp' => '081223344556',
                'alamat' => 'Jl. Asia Afrika No. 25, Bandung',
                'lat' => -6.991349,
                'long' => 107.841578,
            ],
        ];

        foreach ($calonPelanggans as $calonPelanggan) {
            CalonPelanggan::create($calonPelanggan);
        }
    }
}
