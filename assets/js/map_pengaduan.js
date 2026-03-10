document.addEventListener("DOMContentLoaded", () => {

    const DEFAULT_LAT = -8.566260;
    const DEFAULT_LNG = 115.300647;

    let map, marker, desaPolygon;
    let locationValid = false;

    function stripZ(coords) {
        return coords.map(polygon =>
            polygon.map(ring =>
                ring.map(c => [c[0], c[1]])
            )
        );
    }


    function normalizeGeoJSON(geojson) {
        geojson.features.forEach(f => {
            f.geometry.coordinates = stripZ(f.geometry.coordinates);
        });
        return geojson;
    }


    fetch(BASE_URL + "assets/geojson/kelurahan.geojson")
        .then(res => res.json())
        .then(data => {

            const clean = normalizeGeoJSON(data);

            desaPolygon = clean.features.find(
                f => f.properties.nm_kelurahan === "Blahbatuh"
            );

            if (!desaPolygon) {
                alert("Polygon Desa Blahbatuh tidak ditemukan");
                return;
            }

            initLocation();
        });


    function initLocation() {
        if (!navigator.geolocation) {
            showLocationError("Browser tidak mendukung geolokasi.");
            initMap(DEFAULT_LAT, DEFAULT_LNG);
            return;
        }

        navigator.geolocation.getCurrentPosition(
            pos => {
                locationValid = true;
                initMap(pos.coords.latitude, pos.coords.longitude);
            },
            error => {
                let message = "Lokasi tidak dapat diakses.";
                switch (error.code) {
                    case error.PERMISSION_DENIED:
                        message = "Izin lokasi ditolak. Menampilkan lokasi default.";
                        break;
                    case error.POSITION_UNAVAILABLE:
                        message = "Informasi lokasi tidak tersedia. Menampilkan lokasi default.";
                        break;
                    case error.TIMEOUT:
                        message = "Permintaan lokasi habis waktu. Menampilkan lokasi default.";
                        break;
                }
                showLocationError(message);
                initMap(DEFAULT_LAT, DEFAULT_LNG);
            },  
            { enableHighAccuracy: true, timeout: 10000 }
        );
    }

    function showLocationError(message) {
        locationValid = false;
        Swal.fire({
            icon: "warning",
            title: "Lokasi Tidak Aktif",
            text: message
        });
    }

    function initMap(lat, lng) {
        map = L.map("map_pengaduan").setView([lat, lng], 15);

        L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
            attribution: "© OpenStreetMap"
        }).addTo(map);

        const desaLayer = L.geoJSON(desaPolygon, {
            style: {
                color: "#1E88E5",
                weight: 2,
                fillOpacity: 0.3
            },
            interactive: false
        }).addTo(map);

        map.fitBounds(desaLayer.getBounds());

        marker = L.marker([lat, lng]).addTo(map);

        updateLocation(lat, lng);

    // marker.on("dragend", () => {
    //     const p = marker.getLatLng();
    //     updateLocation(p.lat, p.lng);
    // });
    }



    function updateLocation(lat, lng) 
    {
        document.getElementById("latitude").value = lat; 
        document.getElementById("longitude").value = lng; 
        
        reverseGeocode(lat, lng); 
        const inside = isInsideDesa(lat, lng); 
        console.log(`Marker di (${lat}, ${lng}) → inside desa?`, inside); 
        
        if (!inside) {
            locationValid = false;
            Swal.fire({ 
                icon: "warning", 
                title: "Lokasi di luar desa", 
                text: "Pengaduan hanya dapat dilakukan di wilayah Desa Blahbatuh" 
                });
        } else {
            locationValid = true;
        }
            
            
    }



    //turf akan memvalidasi apakah titik marker berada di dalam polygon desa
    function isInsideDesa(lat, lng) 
    { 
        const point = turf.point([lng, lat]); 
        // console.log("Point dicek:", point); 
        // console.log("Polygon desa:", desaPolygon.geometry); 
        
        const inside = turf.booleanPointInPolygon(point, desaPolygon.geometry); 
        // console.log("Hasil validasi:", inside); 
        return inside; 
    }



    //Menggunakan LocationIQ
    function reverseGeocode(lat, lng) {
    const apiKey = "pk.2909d4bad164eeb3d62482cdee056128"; 

    fetch(`https://us1.locationiq.com/v1/reverse?key=${apiKey}&lat=${lat}&lon=${lng}&format=json`)
        .then(res => {
            if (!res.ok) {
                throw new Error("Response tidak OK");
            }
            return res.json();
        })
        .then(data => {
            console.log("Hasil reverse geocode:", data);
            document.getElementById('lokasi_pengaduan').value =
                data.display_name || 'Alamat tidak ditemukan';
        })
        .catch(err => {
            console.error("Error reverse geocode:", err);
            document.getElementById('lokasi_pengaduan').value =
                'Gagal mengambil alamat';
        });
    }

    const form = document.querySelector("form");

    form.addEventListener("submit", function(e) {
        if (!locationValid) {
            e.preventDefault();

            Swal.fire({
                icon: "error",
                title: "Gagal Mengirim",
                text: "Aktifkan lokasi dan pastikan berada di dalam wilayah desa."
            });
        }
    });


});


    //Menggunakan Nominatim OpenStreetMap
    // function reverseGeocode(lat, lng) {
    //     if (!lat || !lng) {
    //         document.getElementById('lokasi_pengaduan').value = 'Koordinat tidak valid';
    //         return;
    //     }

    //     fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`, {
    //         headers: {
    //             "User-Agent": "PengaduanMasyarakat/1.0", // identitas aplikasi
    //             "Accept": "application/json"                   // format data yang diinginkan
    //         }
    //     })
    //     .then(res => {
    //         if (!res.ok) {
    //             throw new Error("Response tidak OK");
    //         }
    //         return res.json();
    //     })
    //     .then(data => {
    //         console.log("Hasil reverse geocode:", data); 
    //         document.getElementById('lokasi_pengaduan').value =
    //             data.display_name || 'Alamat tidak ditemukan';
    //     })
    //     .catch(err => {
    //         console.error("Error reverse geocode:", err);
    //         document.getElementById('lokasi_pengaduan').value =
    //             'Gagal mengambil alamat';
    //     });
    // }