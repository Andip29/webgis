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
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Our Location</h5>
                    </div>
                    <div class="card-body">
                        <div class="googlemaps">
                            <div id="map"></div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>


<script>
	// TO MAKE THE MAP APPEAR YOU MUST
	// ADD YOUR ACCESS TOKEN FROM
	// https://account.mapbox.com
	mapboxgl.accessToken = 'pk.eyJ1IjoiZHVyaWZ3aWZpIiwiYSI6ImNsdjIyZmt3bzBkZHgybG9xOHEwYm5jNGwifQ.HxO7nPuOwiBZl8661VmHxQ';;
    const map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/streets-v9',
        projection: 'globe', // Display the map as a globe, since satellite-v9 defaults to Mercator
        zoom: 14,
        center: [107.8329728,-6.9893175 ]
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
