@extends('layouts.main')

@section('content')
    <h2>Detail ODP: {{ $odp->nama }}</h2>
    <p>{{ $odp->deskripsi }}</p>

    <div id="map" style="width: 100%; height: 500px;"></div>
@endsection

@section('scripts')
<script>
    mapboxgl.accessToken = '{{ env("MAPBOX_KEY") }}';

    const odpData = {
        type: 'Feature',
        geometry: {
            type: 'Point',
            coordinates: [{{ $odp->longitude }}, {{ $odp->latitude }}]
        },
        properties: {
            title: "{{ $odp->nama }}",
            description: "{{ $odp->deskripsi }}",
            image: "{{ asset('storage/' . $odp->gambar) }}"
        }
    };

    const map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/streets-v11',
        center: odpData.geometry.coordinates,
        zoom: 14,
        projection: 'globe'
    });

    const el = document.createElement('div');
    el.className = 'marker';

    new mapboxgl.Marker(el)
        .setLngLat(odpData.geometry.coordinates)
        .setPopup(
            new mapboxgl.Popup({ offset: 25 }).setHTML(`
                <div>
                    <strong>${odpData.properties.title}</strong><br>
                    <img src="${odpData.properties.image}" alt="" width="100"><br>
                    <small>${odpData.properties.description}</small>
                </div>
            `)
        )
        .addTo(map);
</script>
@endsection
