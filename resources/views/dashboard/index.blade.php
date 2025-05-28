@extends('layouts.main')
@section('title', 'Dashboard')
@section('container')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Map</h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
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
@section('maps')
<script>
	
	mapboxgl.accessToken = '{{env("MAPBOX_KEY")}}';

    const map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/streets-v11',
        projection: 'globe', // Display the map as a globe, since satellite-v9 defaults to Mercator
        zoom: 15,
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
                        port: "{{ $odp->port }}",
                        stok: {{ $odp->stok }}
                    }
                },
            @endforeach
        ]
    };

    // add markers to map
    for (const feature of odpGeoJSON.features) {
        new mapboxgl.Marker({
        color: feature.properties.stok === 0 ? 'red' : 'blue'
    })

        .setLngLat(feature.geometry.coordinates)
        .setPopup(
        new mapboxgl.Popup({ offset: 25 }) // add popups
            .setHTML(
            `
            <div style="overflow-y, auto; max-height: 400px, width:100%, ">
                <table class="table table-borderless text-body">
                    <tbody>
                    <tr>
                         <td colspan="2"><strong>${feature.properties.title}</strong></td>
                    </tr>
                    <tr>
                        <td>port</td>
                        <td>${feature.properties.port}</td>
                    </tr>
                    <tr>
                        <td>stok</td>
                        <td>${feature.properties.stok}</td>
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
                        name: "{{ $calonPelanggan->name }}",
                        alamat: "{{ $calonPelanggan->alamat }}",
                        no_telp: "{{ $calonPelanggan->no_telp}}"
                    }
                },
            @endforeach
        ]
    };

    // add markers to map
    for (const feature of calonPelangganGeoJSON.features) {
        new mapboxgl.Marker({
        color: 'yellow'
    })
        .setLngLat(feature.geometry.coordinates)
        .setPopup(
        new mapboxgl.Popup({ offset: 25 }) // add popups
            .setHTML(
            `
            <div style="overflow-y, auto; max-height: 400px, width:100%, ">
                <table class="table table-borderless text-body">
                    <tbody>
                    <tr>
                         <td colspan="2"><strong>${feature.properties.name}</strong></td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td>${feature.properties.alamat}</td>
                    </tr>
                    <tr>
                        <td>No.Telp</td>
                        <td>${feature.properties.no_telp}</td>
                    </tr>
                    </tbody>
                </table>
                </div>`
        )
    )
  .addTo(map);
}


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