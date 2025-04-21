@extends('layouts.main')
@section('title', 'Detail')
@section('container')
<div class="container">
    <h3>Detail Calon Pelanggan</h3>

    <table class="table table-bordered mt-3">
        <tr>
            <th>Nama</th>
            <td>{{ $calonPelanggan->name }}</td>
        </tr>
        <tr>
            <th>Email</th>
            <td>{{ $calonPelanggan->email }}</td>
        </tr>
        <tr>
            <th>No Telepon</th>
            <td>{{ $calonPelanggan->no_telp }}</td>
        </tr>
        <tr>
            <th>Alamat</th>
            <td>{{ $calonPelanggan->alamat }}</td>
        </tr>
        <tr>
            <th>Latitude</th>
            <td>{{ $calonPelanggan->lat }}</td>
        </tr>
        <tr>
            <th>Longitude</th>
            <td>{{ $calonPelanggan->long }}</td>
        </tr>
    </table>

    <div class="col-md-10">
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
</div>
@endsection
@section('maps')
<script>
   mapboxgl.accessToken = '{{ env("MAPBOX_KEY") }}';
    const calonLat = {{ $calonPelanggan->lat }};
    const calonLong = {{ $calonPelanggan->long }};

    const map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/streets-v11',
        projection: 'globe',
        center: [calonLong, calonLat],
        zoom: 13
    });

    // GeoJSON Calon Pelanggan
    const calonPelangganGeoJSON = {
        type: 'Feature',
        geometry: {
            type: 'Point',
            coordinates: [calonLong, calonLat]
        },
        properties: {
            title: "{{ $calonPelanggan->name }}",
            description: "{{ $calonPelanggan->description }}",
            image: "{{ asset('storage/' . $calonPelanggan->image) }}"
        }
    };

     // Tambahkan marker calon pelanggan (CSS custom)
     const elCalon = document.createElement('div');
    elCalon.className = 'marker-calonpelanggan';

    new mapboxgl.Marker(elCalon)
        .setLngLat(calonPelangganGeoJSON.geometry.coordinates)
        .setPopup(
            new mapboxgl.Popup({ offset: 25 }).setHTML(`
                <div style="overflow-y: auto; max-height: 400px; width:100%;">
                    <table class="table table-borderless text-body">
                        <tbody>
                            <tr>
                                <td colspan="2"><strong>${calonPelangganGeoJSON.properties.title}</strong></td>
                            </tr>
                            <tr>
                                <td>Gambar</td>
                                <td><img src="${calonPelangganGeoJSON.properties.image}" loading="lazy" class="img-fluid"></td>
                            </tr>
                            <tr>
                                <td>Jumlah</td>
                                <td>${calonPelangganGeoJSON.properties.description}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            `)
        )
        .addTo(map);

        // Geojson ODP
        const odpGeoJSON = {
        type: 'FeatureCollection',
        features: [
            @foreach ($odps as $odp)
                {
                    type: 'Feature',
                    geometry: {
                        type: 'Point',
                        coordinates: [{{ $odp->long }}, {{ $odp->lat }}]
                    },
                    properties: {
                        title: "{{ $odp->name }}",
                        description: "{{ $odp->description }}",
                        jumlah_user: {{$odp->jumlah_user}}
                    }
                },
            @endforeach
        ]
    };


      // Fungsi menghitung jarak antara dua titik koordinat (Haversine)
      function getDistance(lat1, lon1, lat2, lon2) {
        const R = 6371; // Radius bumi dalam km
        const dLat = (lat2 - lat1) * Math.PI / 180;
        const dLon = (lon2 - lon1) * Math.PI / 180;
        const a = 
            Math.sin(dLat/2) * Math.sin(dLat/2) +
            Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) * 
            Math.sin(dLon/2) * Math.sin(dLon/2);
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        return R * c;
    }

    // Cari ODP terdekat
    let nearestODP = null;
    let minDistance = Infinity;

    for (const feature of odpGeoJSON.features) {
        const [lon, lat] = feature.geometry.coordinates;
        const distance = getDistance(calonLat, calonLong, lat, lon);

        if (distance < minDistance) {
            minDistance = distance;
            nearestODP = feature;
        }
    }

    // add markers ODP
    for (const feature of odpGeoJSON.features) {
        const el = document.createElement('div');
        el.className = 'marker-odp';

     // Tandai ODP terdekat (misalnya ubah warna)
     if (feature === nearestODP) {
            el.style.backgroundColor = 'red';
            el.style.width = '30px';
            el.style.height = '30px';
            el.style.borderRadius = '50%';
        }

   new mapboxgl.Marker(el)
            .setLngLat(feature.geometry.coordinates)
            .setPopup(
                new mapboxgl.Popup({ offset: 25 }).setHTML(`
                    <div style="overflow-y: auto; max-height: 400px; width:100%;">
                        <table class="table table-borderless text-body">
                            <tbody>
                                <tr>
                                    <td colspan="2"><strong>${feature.properties.title}</strong></td>
                                </tr>
                                <tr>
                                    <td>kapasitas</td>
                                    <td>${feature.properties.jumlah_user}</td>
                                </tr>
                                <tr>
                                    <td>deskripsi</td>
                                    <td>${feature.properties.description}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                `)
            )
            .addTo(map);
    }

    // Tambahkan garis ke ODP terdekat
    map.on('load', () => {
        map.addSource('line-to-odp', {
            type: 'geojson',
            data: {
                type: 'Feature',
                geometry: {
                    type: 'LineString',
                    coordinates: [
                        [calonLong, calonLat],
                        nearestODP.geometry.coordinates
                    ]
                }
            }
        });

        map.addLayer({
            id: 'line-to-odp',
            type: 'line',
            source: 'line-to-odp',
            layout: {},
            paint: {
                'line-color': '#ff0000',
                'line-width': 3,
                'line-dasharray': [2, 4]
            }
        });

        // Tambahkan label jarak
        new mapboxgl.Popup({ closeOnClick: false })
            .setLngLat([
                (calonLong + nearestODP.geometry.coordinates[0]) / 2,
                (calonLat + nearestODP.geometry.coordinates[1]) / 2
            ])
            .setHTML(`<strong>Jarak: ${minDistance.toFixed(2)} km</strong>`)
            .addTo(map);
    });
</script>
@endsection


