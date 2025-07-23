<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Odp extends Model
{
    use HasFactory;

    protected $table = "odps";
    protected $fillable = ['name', 'stok', 'port', 'lat', 'long'];

    public function calonPelanggans()
    {
        return $this->hasMany(CalonPelanggan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
