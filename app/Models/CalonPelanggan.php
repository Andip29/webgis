<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalonPelanggan extends Model
{
    use HasFactory;
    protected $table = "calon_pelanggans";
    protected $fillable = [
        'name',
        'email',
        'no_telp',
        'alamat',
        'lat',
        'long',
    ];
}
