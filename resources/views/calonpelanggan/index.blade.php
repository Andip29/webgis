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
                    <button 
                        class="btn btn-danger btn-sm btn-hapus" 
                        data-id="{{ $data->id }}" 
                        data-bs-toggle="modal" 
                        data-bs-target="#modalHapus">
                        Hapus
                    </button>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>

        <!-- Modal Konfirmasi Hapus -->
    <div class="modal fade" id="modalHapus" tabindex="-1" aria-labelledby="modalHapusLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <form action="{{ route('calonpelanggan.destroy', $data->id)}}" id="hapusForm" method="POST">
            @csrf
            @method('DELETE')
            <div class="modal-header">
            <h5 class="modal-title" id="modalHapusLabel">Konfirmasi Hapus</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
            Apakah Anda yakin ingin menghapus data calon pelanggan ini?
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-danger">Hapus</button>
            </div>
        </form>
        </div>
    </div>
    </div>

</div>
@endsection

@section('scripts')
<script>
    const modal = document.getElementById('modalHapus');
    const form = document.getElementById('hapusForm');

    modal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const id = button.getAttribute('data-id');

        // Ubah action form
        form.action = `/calonpelanggan/${id}`;
    });
</script>
@endsection

