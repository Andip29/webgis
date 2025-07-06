@extends('layouts.main')
@section('title', 'Detail')
@section('container')
<div class="container">
    <h3>Detail Calon Pelanggan</h3>

    {{-- Tabel informasi calon pelanggan --}}
    <table class="table table-bordered mt-3">
        <tr><th>Nama</th><td>{{ $calonPelanggan->name }}</td></tr>
        <tr><th>Email</th><td>{{ $calonPelanggan->email }}</td></tr>
        <tr><th>No Telepon</th><td>{{ $calonPelanggan->no_telp }}</td></tr>
        <tr><th>Alamat</th><td>{{ $calonPelanggan->alamat }}</td></tr>
        <tr><th>Latitude</th><td>{{ $calonPelanggan->lat }}</td></tr>
        <tr><th>Longitude</th><td>{{ $calonPelanggan->long }}</td></tr>
    </table>

    <div class="row">
        <div class="col-md-8">
            {{-- Peta lokasi --}}
            <div class="card">
                <div class="card-header"><h5 class="card-title">Our Location</h5></div>
                <div class="card-body"><div class="maps"><div id="map"></div></div></div>
            </div>
        </div>

        <div class="col-md-4">
            {{-- Informasi ODP yang sudah dipilih --}}
            @if($calonPelanggan->odp)
            <div class="card mt-4">
                <div class="card-header bg-success text-white"><strong>ODP Terpilih</strong></div>
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

    {{-- Daftar Rekomendasi ODP terdekat --}}
    <div id="odp-list-container" class="mt-4">
        <h3>Pilih ODP Terdekat:</h3>
        <div id="odp-list" class="d-flex flex-wrap gap-2 mb-3" role="group" aria-label="Daftar ODP"></div>
        <button id="save-odp-btn" class="btn btn-success" disabled>Simpan ODP</button>
    </div>
</div>
@endsection

@section('maps')
<script>
// Konfigurasi akses token Mapbox
mapboxgl.accessToken = '{{ env("MAPBOX_KEY") }}';

// Koordinat calon pelanggan
const calonLat = {{ $calonPelanggan->lat }};
const calonLong = {{ $calonPelanggan->long }};
const selectedOdpId = {{ $selectedOdpId ?? 'null' }};

// Inisialisasi peta
const map = new mapboxgl.Map({
    container: 'map',
    style: 'mapbox://styles/mapbox/streets-v11',
    center: [calonLong, calonLat],
    zoom: 15
});

// Tambahkan marker untuk calon pelanggan
new mapboxgl.Marker({ color: 'yellow' })
    .setLngLat([calonLong, calonLat])
    .setPopup(new mapboxgl.Popup({ offset: 25 }).setHTML(`<strong>{{ $calonPelanggan->name }}</strong><br>{{ $calonPelanggan->alamat }}`))
    .addTo(map);

// Fungsi menghitung jarak antar koordinat (haversine formula)
function getDistance(lat1, lon1, lat2, lon2) {
    const R = 6371;
    const dLat = (lat2 - lat1) * Math.PI / 180;
    const dLon = (lon2 - lon1) * Math.PI / 180;
    const a = Math.sin(dLat/2)**2 + Math.cos(lat1 * Math.PI/180) * Math.cos(lat2 * Math.PI/180) * Math.sin(dLon/2)**2;
    return R * 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
}

// Fungsi menggambar garis dari calon pelanggan ke ODP
function gambarGarisKeODP(dari, ke) {
    if (map.getSource('line-to-odp')) {
        map.removeLayer('line-to-odp');
        map.removeSource('line-to-odp');
    }
    map.addSource('line-to-odp', {
        type: 'geojson',
        data: {
            type: 'Feature',
            geometry: { type: 'LineString', coordinates: [dari, ke] }
        }
    });
    map.addLayer({
        id: 'line-to-odp',
        type: 'line',
        source: 'line-to-odp',
        layout: {},
        paint: { 'line-color': '#ff0000', 'line-width': 3, 'line-dasharray': [2, 4] }
    });
}

// Menyusun data ODP menjadi GeoJSON
const odpGeoJSON = {
    type: 'FeatureCollection',
    features: [
        @foreach ($odps as $odp)
        {
            type: 'Feature',
            geometry: { type: 'Point', coordinates: [{{ $odp->long }}, {{ $odp->lat }}] },
            properties: { id: {{ $odp->id }}, title: "{{ $odp->name }}", port: "{{ $odp->port }}", stok: {{ $odp->stok }} }
        },
        @endforeach
    ]
};

// Filter ODP yang tersedia dalam radius 1km atau ODP terpilih
const availableODPs = odpGeoJSON.features.filter(f => {
    const [lon, lat] = f.geometry.coordinates;
    const distance = getDistance(calonLat, calonLong, lat, lon);
    f.properties.jarak = distance.toFixed(2);
    return (distance <= 1 && parseInt(f.properties.stok) > 0) || f.properties.id === selectedOdpId;
}).sort((a, b) => a.properties.jarak - b.properties.jarak);

let selectedODP = null;
let selectedODPMarker = null;
let distancePopup = null;

const odpListEl = document.getElementById("odp-list");
odpListEl.innerHTML = "";

// Menampilkan daftar tombol ODP
availableODPs.forEach((odp, index) => {
    const btn = document.createElement("button");
    btn.className = "btn btn-outline-primary text-start mb-2";
    btn.dataset.index = index;
    btn.innerHTML = `<strong>${odp.properties.title}</strong><br>Jarak: ${odp.properties.jarak} km<br>Stok: ${odp.properties.stok}`;

    if (odp.properties.id === selectedOdpId) {
        btn.disabled = true;
        btn.classList.replace("btn-outline-primary", "btn-success");
        btn.innerHTML += "<br><em>ODP Terpilih</em>";
    }
    odpListEl.appendChild(btn);
});

// Event saat tombol ODP diklik
odpListEl.addEventListener("click", function (e) {
    const button = e.target.closest("button");
    if (!button) return;
    const selectedIndex = parseInt(button.dataset.index);
    selectedODP = availableODPs[selectedIndex];

    document.getElementById("save-odp-btn").disabled = (selectedODP.properties.id === selectedOdpId);

    document.querySelectorAll("#odp-list button").forEach(btn => btn.classList.replace("btn-primary", "btn-outline-primary"));
    button.classList.replace("btn-outline-primary", "btn-primary");

    if (selectedODPMarker) selectedODPMarker.remove();
    if (distancePopup) distancePopup.remove();

    selectedODPMarker = new mapboxgl.Marker({ color: 'green' })
        .setLngLat(selectedODP.geometry.coordinates)
        .setPopup(new mapboxgl.Popup({ offset: 25 }).setHTML(`<strong>${selectedODP.properties.title}</strong>
        <br>Jarak: ${selectedODP.properties.jarak} km`))
        .addTo(map);

    gambarGarisKeODP([calonLong, calonLat], selectedODP.geometry.coordinates);
});

// Simpan ODP yang dipilih ke database
document.getElementById("save-odp-btn").addEventListener("click", () => {
    if (!selectedODP) return alert("Silakan pilih ODP terlebih dahulu.");

    fetch(`/calonpelanggan/{{ $calonPelanggan->id }}/pilih-odp`, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({ odp_id: selectedODP.properties.id })
    })
    .then(res => res.json().then(data => ({ res, data })))
    .then(({ res, data }) => {
        if (res.ok) {
            alert(data.message || "ODP berhasil disimpan.");
            location.reload();
        } else {
            alert(data.error || "Gagal menyimpan ODP.");
        }
    })
    .catch(() => alert("Terjadi kesalahan."));
});

// Saat peta selesai dimuat, tampilkan garis & marker ODP terpilih
map.on('load', function () {
    if (selectedOdpId) {
        const matchedODP = odpGeoJSON.features.find(f => f.properties.id === selectedOdpId);
        if (matchedODP) {
            new mapboxgl.Marker({ color: 'green' })
                .setLngLat(matchedODP.geometry.coordinates)
                .setPopup(new mapboxgl.Popup({ offset: 25 }).setHTML(`<strong>${matchedODP.properties.title}</strong><br>ODP Terpilih`))
                .addTo(map);

            gambarGarisKeODP([calonLong, calonLat], matchedODP.geometry.coordinates);
        }
    }
});

// Tampilkan semua marker ODP (biru/merah)
odpGeoJSON.features.forEach((feature) => {
    const color = parseInt(feature.properties.stok) === 0 ? 'red' : 'blue';
    new mapboxgl.Marker({ color: color })
        .setLngLat(feature.geometry.coordinates)
        .setPopup(new mapboxgl.Popup({ offset: 25 }).setHTML(`
            <strong>${feature.properties.title}</strong><br>
            Port: ${feature.properties.port}<br>
            Stok: ${feature.properties.stok}`))
        .addTo(map);
});

// Kontrol zoom dan rotasi
map.addControl(new mapboxgl.NavigationControl());
</script>
@endsection
