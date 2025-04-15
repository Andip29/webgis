@extends('dashboard.layouts.main')
@section('title', 'Dashboard')
@section('container')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Google Map</h3>
                <p class="text-subtitle text-muted">Help users find your address</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Google Map</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="row">
            <div class="col-md-12">
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
    </section>
</div>
@endsection
@section('scripts')
<script>
	// TO MAKE THE MAP APPEAR YOU MUST
	// ADD YOUR ACCESS TOKEN FROM
	// https://account.mapbox.com
	mapboxgl.accessToken = '{{env("MAPBOX_KEY")}}';

    const map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/streets-v11',
        projection: 'globe', // Display the map as a globe, since satellite-v9 defaults to Mercator
        zoom: 13,
        center: [107.840366, -6.989709]
    });

    
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
                        image: "{{ asset('storage/' . $odp->image) }}"
                    }
                },
            @endforeach
        ]
    };

    // add markers to map
    for (const feature of odpGeoJSON.features) {
        const el = document.createElement('div');
        el.className = 'marker-odp';

  // make a marker for each feature and add to the map
    // new mapboxgl.Marker(el).setLngLat(feature.geometry.coordinates).addTo(map); 
    new mapboxgl.Marker(el)
        .setLngLat(feature.geometry.coordinates)
        .setPopup(
        new mapboxgl.Popup({ offset: 25 }) // add popups
            .setHTML(
            `
            <div style="overflow-y, auto; max-height: 400px, width:100%, ">
                <table class="table table-borderless text-body">
                    <tbody>
                    <tr>
                        <td>${feature.properties.title}</td>
                    </tr>
                    <tr>
                        <td>image</td>
                        <td><img src="${feature.properties.image}" loading="lazy" class="img-fluid"></td>
                    </tr>
                    <tr>
                        <td>jumlah</td>
                        <td>${feature.properties.description}</td>
                    </tr>
                    </tbody>
                </table>
                </div>`
        )
    )
  .addTo(map);
}

const calonPelangganGeoJSON = {
        type: 'FeatureCollection',
        features: [
            @foreach ($calonPelanggans as $calonPelanggan)
                {
                    type: 'Feature',
                    geometry: {
                        type: 'Point',
                        coordinates: [{{ $calonPelanggan->long }}, {{ $calonPelanggan->lat }}]
                    },
                    properties: {
                        title: "{{ $calonPelanggan->name }}",
                        description: "{{ $calonPelanggan->description }}",
                        image: "{{ asset('storage/' . $calonPelanggan->image) }}"
                    }
                },
            @endforeach
        ]
    };

    // add markers to map
    for (const feature of calonPelangganGeoJSON.features) {
        const el = document.createElement('div');
        el.className = 'marker-calonpelanggan';

  // make a marker for each feature and add to the map
    // new mapboxgl.Marker(el).setLngLat(feature.geometry.coordinates).addTo(map); 
    new mapboxgl.Marker(el)
        .setLngLat(feature.geometry.coordinates)
        .setPopup(
        new mapboxgl.Popup({ offset: 25 }) // add popups
            .setHTML(
            `
            <div style="overflow-y, auto; max-height: 400px, width:100%, ">
                <table class="table table-borderless text-body">
                    <tbody>
                    <tr>
                        <td>${feature.properties.title}</td>
                    </tr>
                    <tr>
                        <td>image</td>
                        <td><img src="${feature.properties.image}" loading="lazy" class="img-fluid"></td>
                    </tr>
                    <tr>
                        <td>description</td>
                        <td>${feature.properties.description}</td>
                    </tr>
                    </tbody>
                </table>
                </div>`
        )
    )
  .addTo(map);
}
    
    map.on('click', function (e) {
            const lat = e.lngLat.lat;
            const lng = e.lngLat.lng;

            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;

            // Tambah marker
            if (marker) marker.remove(); // hapus marker sebelumnya
            marker = new mapboxgl.Marker()
                .setLngLat([lng, lat])
                .addTo(map);
        });

    map.addControl(new mapboxgl.NavigationControl());
    map.scrollZoom.enable();

    map.on('style.load', () => {
        map.setFog({}); // Set the default atmosphere style
    });

    // The following values can be changed to control rotation speed:

    // At low zooms, complete a revolution every two minutes.
    const secondsPerRevolution = 240;
    // Above zoom level 5, do not rotate.
    const maxSpinZoom = 5;
    // Rotate at intermediate speeds between zoom levels 3 and 5.
    const slowSpinZoom = 3;

    let userInteracting = false;
    const spinEnabled = true;

    function spinGlobe() {
        const zoom = map.getZoom();
        if (spinEnabled && !userInteracting && zoom < maxSpinZoom) {
            let distancePerSecond = 360 / secondsPerRevolution;
            if (zoom > slowSpinZoom) {
                // Slow spinning at higher zooms
                const zoomDif =
                    (maxSpinZoom - zoom) / (maxSpinZoom - slowSpinZoom);
                distancePerSecond *= zoomDif;
            }
            const center = map.getCenter();
            center.lng -= distancePerSecond;
            // Smoothly animate the map over one second.
            // When this animation is complete, it calls a 'moveend' event.
            map.easeTo({ center, duration: 1000, easing: (n) => n });
        }
    }

    // Pause spinning on interaction
    map.on('mousedown', () => {
        userInteracting = true;
    });
    map.on('dragstart', () => {
        userInteracting = true;
    });

    // When animation is complete, start spinning if there is no ongoing interaction
    map.on('moveend', () => {
        spinGlobe();
    });

    spinGlobe();
</script>

@endsection

