<?php

namespace App\Imports;

use App\Models\Odp;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class OdpsImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {

        return new Odp([
            'name' => $row['name'],
            'stok' => $row['stok'],
            'port' => $row['port'],
            'lat'  => $row['lat'],
            'long' => $row['long'],
        ]);
    }
}
