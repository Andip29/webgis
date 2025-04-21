<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\odp;
use App\Models\CalonPelanggan;
use Illuminate\Support\Facades\Storage;
class MapController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $odps = odp::all();
        $calonPelanggans = CalonPelanggan::all();
        return view('maps.index', compact('odps','calonPelanggans'));
    }

    public function import(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:csv,txt'
    ]);

    $file = $request->file('file');

    if (($handle = fopen($file, "r")) !== false) {
        $isHeader = true;
        while (($data = fgetcsv($handle, 1000, ",")) !== false) {
            if ($isHeader) {
                $isHeader = false;
                continue;
            }

            // Sesuaikan urutan kolom CSV dengan kolom di database
            odp::create([
                'name' => $data[0],
                'lat' => $data[1],
                'long' => $data[2],
                'description' => $data[3],
                'jumlah_user' => $data[4],
            ]);
        }
        fclose($handle);
    }

    return redirect()->route('map.index')->with('success', 'Data berhasil diimpor!');
}



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
