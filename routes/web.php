<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\CalonPelangganController;
use App\Models\CalonPelanggan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('dashboard/index');
// });

route::get('/', [LoginController::class, 'index'])->name('login')->middleware('guest');
route::post('/login', [LoginController::class, 'authenticate'])->name('authenticate');
route::post('/', [LoginController::class, 'logout'])->name('logout');

route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth');
route::get('map', [MapController::class, 'index'])->name('map.index')->middleware('auth');
Route::post('/map/import', [MapController::class, 'import'])->name('map.import')->middleware('auth');
Route::resource('calonpelanggan', CalonPelangganController::class)->middleware('auth');
Route::post('/calonpelanggan/{id}/pilih-odp', [CalonPelangganController::class, 'simpanODP']);
Route::patch('/calonpelanggan/{id}/update-status', [CalonPelangganController::class, 'updateStatus'])->name('calonpelanggan.updateStatus');
