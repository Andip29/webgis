<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Odp;
use App\Models\CalonPelanggan;

class DashboardController extends Controller
{
    public function index()
    {

        $odps = Odp::all();
        $calonPelanggans = CalonPelanggan::all();
        return view('dashboard.index', compact('odps', 'calonPelanggans'));
    }
}
