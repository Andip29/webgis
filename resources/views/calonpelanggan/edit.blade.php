@extends('layouts.main')
@section('title', 'Dashboard')
@section('container')
<div class="container">
    <h3>Edit Calon Pelanggan</h3>
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Our Location</h5>
                </div>
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
                    <form action="{{ route('calonpelanggan.update', $calonPelanggan->id) }}"  method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label>Nama</label>
                        <input type="text" name="name" value="{{ $calonPelanggan->name }}" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" value="{{ $calonPelanggan->email }}" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>No Telepon</label>
                        <input type="text" name="no_telp" value="{{ $calonPelanggan->no_telp }}" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Alamat</label>
                        <textarea name="alamat" class="form-control">{{ $calonPelanggan->alamat }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label>Latitude</label>
                        <input type="text" name="lat" id="lat" value="{{ $calonPelanggan->lat }}" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Longitude</label>
                        <input type="text" name="long" id="long" value="{{ $calonPelanggan->long }}" class="form-control">
                    </div>
                    <button class="btn btn-primary">Update</button>
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
        center: [{{ $calonPelanggan->long }}, {{ $calonPelanggan->lat }}],
        zoom: 13
    });

    let marker = new mapboxgl.Marker()
        .setLngLat([{{ $calonPelanggan->long }}, {{ $calonPelanggan->lat }}])
        .addTo(map);

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

