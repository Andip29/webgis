<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CalonPelanggan;
use App\Models\Odp;
use Illuminate\Support\Facades\Log;


class CalonPelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $calonPelanggans = CalonPelanggan::all();
        return view('calonpelanggan.index', compact('calonPelanggans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('calonpelanggan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'no_telp' => 'required',
            'alamat' => 'required',
            'lat' => 'required',
            'long' => 'required',
        ]);

        CalonPelanggan::create($request->all());

        return redirect()->route('calonpelanggan.index')->with('success', 'Data berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show($calonPelanggan)
    {
        $odps = Odp::all();
        $calonPelanggan = CalonPelanggan::findOrFail($calonPelanggan);
        $selectedOdpId = $calonPelanggan->odp_id;
        return view('calonpelanggan.show', compact('calonPelanggan', 'odps', 'selectedOdpId'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($calonPelanggan)
    {
        $calonPelanggan = CalonPelanggan::findOrFail($calonPelanggan);
        return view('calonpelanggan.edit', compact('calonPelanggan'));
    }

    /**
     * Update the specified resource in storage.s
     */
    public function update(Request $request, $calonPelanggan)
    {
        $calonPelanggan = CalonPelanggan::findOrFail($calonPelanggan);
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'no_telp' => 'required',
            'alamat' => 'required',
            'lat' => 'required',
            'long' => 'required',
        ]);

        $calonPelanggan->update($request->all());

        return redirect()->route('calonpelanggan.index')->with('success', 'Data berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($calonPelanggan)
    {
        $calonPelanggan = CalonPelanggan::findOrFail($calonPelanggan);
        $calonPelanggan->delete();
        return redirect()->route('calonpelanggan.index')->with('success', 'Data berhasil dihapus.');
    }

    public function simpanODP(Request $request, $id)
    {
        $request->validate([
            'odp_id' => 'required|exists:odps,id',
        ]);

        $calonPelanggan = CalonPelanggan::findOrFail($id);

        // Cegah penyimpanan ulang ODP yang sama
        if ($calonPelanggan->odp_id == $request->odp_id) {
            return response()->json(['error' => 'ODP ini sudah dipilih oleh calon pelanggan ini.'], 400);
        }

        // Jika sebelumnya sudah ada ODP, kembalikan stok
        if ($calonPelanggan->odp_id) {
            $odpLama = Odp::find($calonPelanggan->odp_id);
            if ($odpLama) {
                $odpLama->stok++;
                $odpLama->save();
            }
        }

        // Simpan ODP baru
        $odpBaru = Odp::findOrFail($request->odp_id);
        if ($odpBaru->stok <= 0) {
            return response()->json(['error' => 'Stok ODP tidak tersedia.'], 400);
        }

        $odpBaru->stok--;
        $odpBaru->save();

        $calonPelanggan->odp_id = $odpBaru->id;
        $calonPelanggan->save();

        return response()->json(['message' => 'ODP berhasil dipilih.']);
    }
}
