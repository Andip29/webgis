<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class odp extends Model
{
    use HasFactory;

    protected $table = "odps";
    protected $fillable = ['name', 'jumlah_user', 'description', 'lat', 'long', 'image'];
}
