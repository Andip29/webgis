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
        @if($calonPelanggan->odp)
        <div class="card mt-4">
            <div class="card-header bg-success text-white">
                <strong>ODP Terpilih</strong>
            </div>
            <div class="card-body">
                <p><strong>Nama ODP:</strong> {{ $calonPelanggan->odp->name }}</p>
                <p><strong>Jumlah Port:</strong> {{ $calonPelanggan->odp->port }}</p>
                <p><strong>Sisa Stok:</strong> {{ $calonPelanggan->odp->stok }}</p>
                <p><strong>Koordinat:</strong> {{ $calonPelanggan->odp->lat }}, {{ $calonPelanggan->odp->long }}</p>
            </div>
        </div>
        @endif
    </div>
</div>

    <div id="odp-list-container" class="mt-4">
        <h3>Pilih ODP Terdekat:</h3>
        <div id="odp-list" class="d-flex flex-wrap gap-2 mb-3" role="group" aria-label="Daftar ODP"></div>
         <button id="save-odp-btn" class="btn btn-success" disabled>Simpan ODP</button>
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
    const selectedOdpId = {{ $selectedOdpId ?? 'null' }};

    const map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/streets-v11',
        center: [calonLong, calonLat],
        zoom: 15
    });

// Marker Calon Pelanggan
new mapboxgl.Marker({ color: 'yellow' }) // 
    .setLngLat([calonLong, calonLat])
    .setPopup(
        new mapboxgl.Popup({ offset: 25 }).setHTML(`
            <strong>{{ $calonPelanggan->name }}</strong><br>
            {{ $calonPelanggan->alamat }}
        `)
    )
    .addTo(map);

// Data ODP
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
                id: {{ $odp->id }},
                title: "{{ $odp->name }}",
                port: "{{ $odp->port }}",
                stok: {{ $odp->stok }}
            }
        },
        @endforeach
    ]
};

// menghitung jarak
function getDistance(lat1, lon1, lat2, lon2) {
    const R = 6371;
    const dLat = (lat2 - lat1) * Math.PI / 180;
    const dLon = (lon2 - lon1) * Math.PI / 180;
    const a =
        Math.sin(dLat / 2) * Math.sin(dLat / 2) +
        Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
        Math.sin(dLon / 2) * Math.sin(dLon / 2);
    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    return R * c;
}

// Siapkan data ODP yang tersedia
const availableODPs = odpGeoJSON.features
    .filter(f => {
        const [lon, lat] = f.geometry.coordinates;
        const distance = getDistance(calonLat, calonLong, lat, lon);
        f.properties.jarak = distance.toFixed(2);
        return distance <= 2 && parseInt(f.properties.stok) > 0;
    })
    .sort((a, b) => a.properties.jarak - b.properties.jarak);


let selectedODPMarker = null;
let distancePopup = null;
let previousODPId = selectedOdpId;
let selectedODP = null;

// Render daftar ODP
if (availableODPs.length > 0) {
    const odpListEl = document.getElementById("odp-list");
    odpListEl.innerHTML = "";
    availableODPs.forEach((odp, index) => {
        const btn = document.createElement("button");
        btn.className = "btn btn-outline-primary text-start mb-2";
        btn.dataset.index = index;
        btn.innerHTML = `
            <strong>${odp.properties.title}</strong><br>
            Jarak: ${odp.properties.jarak} km<br>
            Stok: ${odp.properties.stok}
        `;

        // Tambahkan pengecekan jika ODP ini sudah dipilih
    if (odp.properties.id === selectedOdpId) {
        btn.disabled = true;
        btn.classList.remove("btn-outline-primary");
        btn.classList.add("btn-success");
        btn.innerHTML += "<br><em>ODP Terpilih</em>";
    }
    odpListEl.appendChild(btn);
});


    odpListEl.addEventListener("click", function (e) {
        if (e.target.tagName === "BUTTON") {
            const button = e.target.closest("button");
            const selectedIndex = parseInt(e.target.dataset.index);
            selectedODP = availableODPs[selectedIndex];
            if (selectedODP.properties.id === selectedOdpId) {
                document.getElementById("save-odp-btn").disabled = true;
            } else {
                document.getElementById("save-odp-btn").disabled = false;
            }

            // Highlight tombol yang dipilih
            document.querySelectorAll("#odp-list button").forEach(btn => {
                btn.classList.remove("btn-primary");
                btn.classList.add("btn-outline-primary");
            });
            e.target.classList.remove("btn-outline-primary");
            e.target.classList.add("btn-primary");


            // Hapus sebelumnya
            if (selectedODPMarker) selectedODPMarker.remove();
            if (map.getSource('line-to-odp')) {
                map.removeLayer('line-to-odp');
                map.removeSource('line-to-odp');
            }
            if (distancePopup) distancePopup.remove();

            // Tambah marker hijau  
            selectedODPMarker = new mapboxgl.Marker({ color: 'green' })
                .setLngLat(selectedODP.geometry.coordinates)
                .setPopup(new mapboxgl.Popup({ offset: 25 }).setHTML(`<strong>${selectedODP.properties.title}</strong><br>Jarak: ${selectedODP.properties.jarak} km`))
                .addTo(map);

            // Gambar garis
            map.addSource('line-to-odp', {
                type: 'geojson',
                data: {
                    type: 'Feature',
                    geometry: {
                        type: 'LineString',
                        coordinates: [
                            [calonLong, calonLat],
                            selectedODP.geometry.coordinates
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

            // Popup jarak
            const midLng = (calonLong + selectedODP.geometry.coordinates[0]) / 2;
            const midLat = (calonLat + selectedODP.geometry.coordinates[1]) / 2;

            distancePopup = new mapboxgl.Popup({ closeOnClick: false })
                .setLngLat([midLng, midLat])
                .setHTML(`<strong>Jarak: ${selectedODP.properties.jarak} km</strong>`)
                .addTo(map);

            map.flyTo({ center: selectedODP.geometry.coordinates, zoom: 16 });
        }
    });
}

// Tombol Simpan
document.getElementById("save-odp-btn").addEventListener("click", () => {
    if (!selectedODP) {
        alert("Silakan pilih ODP terlebih dahulu.");
        return;
    }

    fetch(`/calon-pelanggan/{{ $calonPelanggan->id }}/pilih-odp`, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({ odp_id: selectedODP.properties.id })
    })
    .then(async res => {
    const data = await res.json();
    if (res.ok) {
        alert(data.message || "ODP berhasil disimpan.");
        location.reload();
    } else {
        alert(data.error || "Gagal menyimpan ODP.");
    }
})
    .catch(err => {
        console.error("Error:", err);
        alert("Terjadi kesalahan.");
    });
});

map.on('load', function () {
    // Render ulang ODP yang sudah disimpan (selectedOdpId) dengan garis dan marker hijau
    if (selectedOdpId) {
        const matchedODP = odpGeoJSON.features.find(f => f.properties.id === selectedOdpId);
        if (matchedODP) {
            const [odpLong, odpLat] = matchedODP.geometry.coordinates;

            // Marker hijau untuk ODP yang tersimpan
            new mapboxgl.Marker({ color: 'green' })
                .setLngLat(matchedODP.geometry.coordinates)
                .setPopup(new mapboxgl.Popup({ offset: 25 }).setHTML(`<strong>${matchedODP.properties.title}</strong><br>ODP Terpilih`))
                .addTo(map);

            // Garis ke ODP
            if (!map.getSource('line-to-odp')) {
                map.addSource('line-to-odp', {
                    type: 'geojson',
                    data: {
                        type: 'Feature',
                        geometry: {
                            type: 'LineString',
                            coordinates: [
                                [calonLong, calonLat],
                                matchedODP.geometry.coordinates
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

                // Popup jarak
                const midLng = (calonLong + odpLong) / 2;
                const midLat = (calonLat + odpLat) / 2;

                new mapboxgl.Popup({ closeOnClick: false })
                    .setLngLat([midLng, midLat])
                    .setHTML(`<strong>ODP Terpilih</strong>`)
                    .addTo(map);
            }
        }
    }
});


// Tampilkan semua ODP dengan warna default
odpGeoJSON.features.forEach((feature) => {
    const color = parseInt(feature.properties.stok) === 0 ? 'red' : 'blue';

    new mapboxgl.Marker({ color: color })
        .setLngLat(feature.geometry.coordinates)
        .setPopup(
            new mapboxgl.Popup({ offset: 25 }).setHTML(`
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
                </div>`)
    )
    .addTo(map);
});

map.addControl(new mapboxgl.NavigationControl());
    
</script>
@endsection


