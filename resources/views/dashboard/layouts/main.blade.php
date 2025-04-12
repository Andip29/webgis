<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    
    <link rel="stylesheet" href="assets/css/main/app.css">
    <link rel="stylesheet" href="assets/css/main/app-dark.css">
    <link rel="shortcut icon" href="assets/images/logo/favicon.svg" type="image/x-icon">
    <link rel="shortcut icon" href="assets/images/logo/favicon.png" type="image/png">
    <link
      href="https://fonts.googleapis.com/css?family=Open+Sans"
      rel="stylesheet"
    />
    <link href="https://api.mapbox.com/mapbox-gl-js/v3.11.0/mapbox-gl.css" rel="stylesheet">
    <script src="https://api.mapbox.com/mapbox-gl-js/v3.11.0/mapbox-gl.js"></script>
    <link rel="stylesheet" href="assets/css/map.css">
    <link rel="stylesheet" href="assets/css/shared/iconly.css">

</head>

<body>
    <div id="app">
    @include('dashboard.layouts.sidebar')
        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>
            
            @yield('container')

        @include('dashboard.layouts.footer')

            

        </div>
    </div>
    <script src="assets/js/bootstrap.js"></script>
    <script src="assets/js/app.js"></script>
    
<!-- Need: Apexcharts -->
<script src="assets/extensions/apexcharts/apexcharts.min.js"></script>
<script src="assets/js/pages/dashboard.js"></script>
<script>
	// TO MAKE THE MAP APPEAR YOU MUST
	// ADD YOUR ACCESS TOKEN FROM
	// https://account.mapbox.com
	mapboxgl.accessToken = '{{env("MAPBOX_KEY")}}';

    const geojson = {
  "type": "FeatureCollection",
  "features": [
    {
      "type": "Feature",
      "geometry": {
        "coordinates": [
          "107.8406235",
          "-6.9887084"
        ],
        "type": "Point"
      },
      "properties": {
        "message": "Mantap",
        "iconSize": [
          50,
          50
        ],
        "locationId": 30,
        "title": "Hello new",
        "image": "1a1eb1e4106fff0cc3467873f0f39cab.jpeg",
        "description": "Mantap"
      }
    },
    {
      "type": "Feature",
      "geometry": {
        "coordinates": [
          "107.8435096",
          "-6.9920523"
        ],
        "type": "Point"
      },
      "properties": {
        "message": "oke mantap Edit",
        "iconSize": [
          50,
          50
        ],
        "locationId": 29,
        "title": "Rumah saya Edit",
        "image": "0ea59991df2cb96b4df6e32307ea20ff.png",
        "description": "oke mantap Edit"
      }
    },
    {
      "type": "Feature",
      "geometry": {
        "coordinates": [
          "107.8404948",
          "-6.9874731"
        ],
        "type": "Point"
      },
      "properties": {
        "message": "Update Baru",
        "iconSize": [
          50,
          50
        ],
        "locationId": 22,
        "title": "Update Baru Gambar",
        "image": "d09444b68d8b72daa324f97c999c2301.jpeg",
        "description": "Update Baru"
      }
    },
    {
      "type": "Feature",
      "geometry": {
        "coordinates": [
          "107.8450224",
          "-6.993804"
        ],
        "type": "Point"
      },
      "properties": {
        "message": "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.",
        "iconSize": [
          50,
          50
        ],
        "locationId": 19,
        "title": "awdwad",
        "image": "f0b88ffd980a764b9fca60d853b300ff.png",
        "description": "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum."
      }
    },
    {
      "type": "Feature",
      "geometry": {
        "coordinates": [
          "107.8450224",
          "-6.993804"
        ],
        "type": "Point"
      },
      "properties": {
        "message": "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.",
        "iconSize": [
          50,
          50
        ],
        "locationId": 18,
        "title": "adwawd",
        "image": "4c35cb1b76af09e6205f94024e093fe6.jpeg",
        "description": "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum."
      }
    },
    {
      "type": "Feature",
      "geometry": {
        "coordinates": [
          "107.8389069",
          "-6.9896456"
        ],
        "type": "Point"
      },
      "properties": {
        "message": "awdwad",
        "iconSize": [
          50,
          50
        ],
        "locationId": 12,
        "title": "adawd",
        "image": "7c8c949fd0499eb50cb33787d680778c.jpeg",
        "description": "awdwad"
      }
    }
  ]
};

    const map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/streets-v11',
        projection: 'globe', // Display the map as a globe, since satellite-v9 defaults to Mercator
        zoom: 13,
        center: [107.840366, -6.989709]
    });

    // add markers to map
    for (const feature of geojson.features) {
  
  // code from step 7-1 will go here
  // create a HTML element for each feature
    const el = document.createElement('div');
    el.className = 'marker';

  // make a marker for each feature and add to the map
    new mapboxgl.Marker(el).setLngLat(feature.geometry.coordinates).addTo(map); // Replace this line with code from step 7-2

   //code from step 8 will go here
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
                    <td><img src="${feature.properties.description}" loading="lazy" class="img-fluid"></td>
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
</body>

</html>
