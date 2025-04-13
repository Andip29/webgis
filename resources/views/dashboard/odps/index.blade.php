@extends('dashboard.layouts.main')
@section('title', 'Dashboard')
@section('container')
<div class="container">
    <h1>Data ODP</h1>

    <a href="{{ route('odps.create') }}" class="btn btn-success mb-3">Tambah ODP</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Jumlah User</th>
                <th>Deskripsi</th>
                <th>Latitude</th>
                <th>Longitude</th>
                <th>Gambar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($odps as $odp)
            <tr>
                <td>{{ $odp->name }}</td>
                <td>{{ $odp->jumlah_user }}</td>
                <td>{{ $odp->description }}</td>
                <td>{{ $odp->lat }}</td>
                <td>{{ $odp->long }}</td>
                <td>
                    @if($odp->image)
                        <img src="{{ asset('uploads/odps/' . $odp->image) }}" width="100">
                    @endif
                </td>
                <td>
                    <a href="{{ route('odps.edit', $odp->id) }}" class="btn btn-primary btn-sm">Edit</a>
                    <form action="{{ route('odps.destroy', $odp->id) }}" method="POST" style="display:inline-block;">
                        @csrf @method('DELETE')
                        <button type="submit" onclick="return confirm('Yakin ingin menghapus?')" class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                    <a href="{{ route('odps.show', $odp->id) }}" class="btn btn-info btn-sm">Detail</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection