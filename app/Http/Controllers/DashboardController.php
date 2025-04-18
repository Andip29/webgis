<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\odp;
use App\Models\CalonPelanggan;

class DashboardController extends Controller
{
    public function index(){

        $odps = odp::all();
        $calonPelanggans = CalonPelanggan::all();
        return view('dashboard.index',compact('odps','calonPelanggans'));

    }
}
