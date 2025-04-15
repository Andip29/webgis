@extends('dashboard.layouts.main')
@section('title', 'Dashboard')
@section('container')
    <div class="container">
        <h3>Edit Calon Pelanggan</h3>
        <div class="row">
            <div class="col-md-8">
                <div id="map" style="height: 70vh;"></div>
            </div>
            <div class="col-md-4">
                <form action="{{ route('calonpelanggan.update', $calonPelanggans->id) }}" method="POST">
                    @method('PUT')
                    @csrf
                    <div class="mb-3">
                        <label>Nama</label>
                        <input type="text" name="name" value="{{ $calonPelanggans->name }}" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" value="{{ $calonPelanggans->email }}" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>No Telepon</label>
                        <input type="text" name="no_telp" value="{{ $calonPelanggans->no_telp }}" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Alamat</label>
                        <textarea name="alamat" class="form-control">{{ $calonPelanggans->alamat }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label>Latitude</label>
                        <input type="text" name="lat" id="lat" value="{{ $calonPelanggans->lat }}"
                            class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Longitude</label>
                        <input type="text" name="long" id="long" value="{{ $calonPelanggans->long }}"
                            class="form-control">
                    </div>
                    <button class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>

    <script src='https://api.mapbox.com/mapbox-gl-js/v2.15.0/mapbox-gl.js'></script>
    <link href='https://api.mapbox.com/mapbox-gl-js/v2.15.0/mapbox-gl.css' rel='stylesheet' />
    {{-- <script>
        mapboxgl.accessToken = '{{ env('MAPBOX_KEY') }}';
        const map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/streets-v11',
            center: [{{ $calonPelanggan->long }}, {{ $calonPelanggan->lat }}],
            zoom: 13
        });

        let marker = new mapboxgl.Marker()
            .setLngLat([{{ $calonPelanggan->long }}, {{ $calonPelanggan->lat }}])
            .addTo(map);

        map.on('click', function(e) {
            const lat = e.lngLat.lat;
            const lng = e.lngLat.lng;

            document.getElementById('lat').value = lat;
            document.getElementById('long').value = lng;

            if (marker) marker.remove();
            marker = new mapboxgl.Marker().setLngLat([lng, lat]).addTo(map);
        });
    </script> --}}
@endsection
