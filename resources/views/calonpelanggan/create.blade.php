@extends('dashboard.layouts.main')
@section('title', 'Dashboard')
@section('container')
<div class="container">
    <h3>Tambah Calon Pelanggan</h3>
    <div class="row">
        <div class="col-md-8">
            <div id="map" style="height: 70vh;"></div>
        </div>
        <div class="col-md-4">
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

{{-- Mapbox --}}
<script src='https://api.mapbox.com/mapbox-gl-js/v2.15.0/mapbox-gl.js'></script>
<link href='https://api.mapbox.com/mapbox-gl-js/v2.15.0/mapbox-gl.css' rel='stylesheet' />
<script>
    mapboxgl.accessToken = '{{ env("MAPBOX_KEY") }}';
    const map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/streets-v11',
        center: [107.840366, -6.989709],
        zoom: 13
    });

    let marker;

    map.on('click', function (e) {
        const lat = e.lngLat.lat;
        const lng = e.lngLat.lng;

        document.getElementById('lat').value = lat;
        document.getElementById('long').value = lng;

        if (marker) marker.remove();
        marker = new mapboxgl.Marker().setLngLat([lng, lat]).addTo(map);
    });
</script>
@endsection

