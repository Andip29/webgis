@extends('layouts.main')
@section('title', 'Calon Pelanggan')
@section('container')
<div class="container">
    <h3>Daftar Calon Pelanggan</h3>
    <a href="{{ route('calonpelanggan.create') }}" class="btn btn-primary mb-3">+ Tambah Data</a>
    <div class="table-responsive">
    <table class="table table-bordered " id="table">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>No Telp</th>
                <th>Alamat</th>
                <th>Koordinat</th>
                <th>ODP</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            @foreach($calonPelanggans as $data)
            <tr>
                <td>{{ $data->name }}</td>
                <td>{{ $data->email }}</td>
                <td>{{ $data->no_telp }}</td>
                <td>{{ $data->alamat }}</td>
                <td>{{ $data->lat }}, {{ $data->long }}</td>
                <td>{{ $data->odp ? $data->odp->name : '-' }}</td>
                <td>
                <form action="{{ route('calonpelanggan.updateStatus', $data->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="belum_terpasang" {{ $data->status == 'belum_terpasang' ? 'selected' : '' }}>Belum Terpasang</option>
                        <option value="terpasang" {{ $data->status == 'terpasang' ? 'selected' : '' }}>Terpasang</option>
                    </select>
                </form>
            </td>
                <td>
                    <div class="d-flex gap-1 flex-wrap">
                    <a href="{{ route('calonpelanggan.show', $data->id) }}" class="btn btn-info btn-sm">Lihat</a>
                    <a href="{{ route('calonpelanggan.edit', $data->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('calonpelanggan.destroy', $data->id) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus data ini?')">Hapus</button>
                    </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>
</div>
@endsection


