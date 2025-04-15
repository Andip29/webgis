<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CalonPelanggan;

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
    public function show(CalonPelanggan $calonPelanggans)
    {
        return view('calonpelanggan.show', compact('calonPelanggans'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CalonPelanggan $calonPelanggans)
    {
        return view('calonpelanggan.edit', compact('calonPelanggans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CalonPelanggan $calonPelanggans)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'no_telp' => 'required',
            'alamat' => 'required',
            'lat' => 'required',
            'long' => 'required',
        ]);
    
        $calonPelanggans->update($request->all());
    
        return redirect()->route('calonpelanggan.index')->with('success', 'Data berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CalonPelanggan $calonPelanggans)
    {
        $calonPelanggans->delete();
        return redirect()->route('calonpelanggan.index')->with('success', 'Data berhasil dihapus.');
    }
}
