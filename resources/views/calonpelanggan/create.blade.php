@extends('layouts.main')
@section('title', 'Tambah Calon Pelanggan')
@section('container')
<div class="container">
    <a href="{{ route('calonpelanggan.index') }}" class="btn btn-secondary mb-3">← Kembali</a>
    <h3>Tambah Calon Pelanggan</h3>
    <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <div class="maps">
                            <div id="map"></div>
                        </div>
                    </div>
                </div>
            </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
            <form action="{{ route('calonpelanggan.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label>Nama</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control">
                </div>
                <div class="mb-3">
                    <label>No Telepon</label>
                    <input type="text" name="no_telp" class="form-control">
                </div>
                <div class="mb-3">
                    <label>Alamat</label>
                    <textarea name="alamat" class="form-control"></textarea>
                </div>
                <div class="mb-3">
                    <label>Latitude</label>
                    <input type="text" name="lat" id="lat" class="form-control" readonly>
                </div>
                <div class="mb-3">
                    <label>Longitude</label>
                    <input type="text" name="long" id="long" class="form-control" readonly>
                </div>
                <button class="btn btn-primary">Simpan</button>
            </form>
             </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('maps')
<script>
    mapboxgl.accessToken = '{{ env("MAPBOX_KEY") }}';
    const map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/streets-v11',
        center: [107.840366, -6.989709],
        zoom: 13
    });

    let calonMarker = null;

    map.on('click', (e) => {
        const { lng, lat } = e.lngLat;

        // Hapus marker sebelumnya
        if (calonMarker) {
            calonMarker.remove();
        }

        // Buat marker baru
        const el = document.createElement('div');
        el.className = 'marker-calonpelanggan';

        calonMarker = new mapboxgl.Marker(el)
            .setLngLat([lng, lat])
            .setPopup(
                new mapboxgl.Popup({ offset: 25 }).setHTML(`
                    <div><strong>Calon Pelanggan</strong><br>Lokasi: ${lat.toFixed(5)}, ${lng.toFixed(5)}</div>
                `)
            )
            .addTo(map)
            .togglePopup();

        // Isi input form
        const inputLat = document.getElementById('lat');
        const inputLong = document.getElementById('long');
        if (inputLat && inputLong) {
            inputLat.value = lat;
            inputLong.value = lng;
        }
    });
</script>
@endsection

