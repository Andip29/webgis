@extends('dashboard.layouts.main')
@section('title', 'Dashboard')
@section('container')
<div class="container">
    <h3>Detail Calon Pelanggan</h3>
    <div class="card">
        <div class="card-body">
            <p><strong>Nama:</strong> {{ $calonPelanggans->name }}</p>
            <p><strong>Email:</strong> {{ $calonPelanggans->email }}</p>
            <p><strong>No Telp:</strong> {{ $calonPelanggans->no_telp }}</p>
            <p><strong>Alamat:</strong> {{ $calonPelanggans->alamat }}</p>
            <p><strong>Latitude:</strong> {{ $calonPelanggans->lat }}</p>
            <p><strong>Longitude:</strong> {{ $calonPelanggans->long }}</p>
        </div>
    </div>
</div>
@endsection


