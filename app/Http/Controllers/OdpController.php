<?php

namespace App\Http\Controllers;
use App\Models\Odp;
use Illuminate\Http\Request;

class OdpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Odp::all();
        return view('dashboard.odps.index', compact('data'));
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
    public function show(Odp $odp)
    {
        return view('dashboard.odps.show', compact(var_name: 'odp'));
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
