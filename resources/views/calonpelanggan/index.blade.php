@extends('layouts.main')
@section('title', 'Calon Pelanggan')
@section('container')
<div class="container">
    <h3>Daftar Calon Pelanggan</h3>
    <a href="{{ route('calonpelanggan.create') }}" class="btn btn-primary mb-3">+ Tambah Data</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>No Telp</th>
                <th>Alamat</th>
                <th>Koordinat</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            
            @foreach($calonPelanggans as $data)
            <tr>
                <td>{{ $data->name }}</td>
                <td>{{ $data->email }}</td>
                <td>{{ $data->no_telp }}</td>
                <td>{{ $data->alamat }}</td>
                <td>{{ $data->lat }}, {{ $data->long }}</td>
                <td>
                    <a href="{{ route('calonpelanggan.show', $data->id) }}" class="btn btn-info btn-sm">Lihat</a>
                    <a href="{{ route('calonpelanggan.edit', $data->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('calonpelanggan.destroy', $data->id) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus data ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection


