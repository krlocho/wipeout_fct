@props(['users'])

<div id="docs-card"
class="flex flex-col items-start gap-6 overflow-hidden rounded-lg bg-white p-6 shadow-[0px_1px_5px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#FF2D20] md:row-span-3 lg:p-10 lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#FF2D20]">
<div id="screenshot-container" class="relative flex items-stretch flex-1 w-full">
    <input id="search-input"
        class="absolute top-0 left-0 z-20 flex px-3 py-2 m-3 text-gray-600 border rounded-md shadow-sm controls focus:outline-none focus:ring-2 focus:ring-indigo-600"
        type="text" placeholder="Buscar lugares" class="">

    <div id="map" style="width: 100% ">


    </div>



</div>

<div class="relative flex items-center gap-6 lg:items-end">
    <div id="docs-card-content" class="flex items-start gap-6 lg:flex-col">
        <div
            class="flex size-12 shrink-0 items-center justify-center rounded-full bg-[#FF2D20]/10 sm:size-16">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);transform: ;msFilter:;">
                <path
                    d="m21.447 6.105-6-3a1 1 0 0 0-.895 0L9 5.882 3.447 3.105A1 1 0 0 0 2 4v13c0 .379.214.725.553.895l6 3a1 1 0 0 0 .895 0L15 18.118l5.553 2.776a.992.992 0 0 0 .972-.043c.295-.183.475-.504.475-.851V7c0-.379-.214-.725-.553-.895zM10 7.618l4-2v10.764l-4 2V7.618zm-6-2 4 2v10.764l-4-2V5.618zm16 12.764-4-2V5.618l4 2v10.764z">
                </path>
            </svg>
        </div>

        <div class="pt-3 sm:pt-5 lg:pt-0">

            <h2 class="text-xl font-semibold text-black dark:text-white">Talleres cercanos
            </h2>

            <p class="mt-4 text-sm/relaxed">
                Encuentra tus talleres de tablas cercanos y descubre los servicios que
                ofrecen. ¡No te quedes sin tu lugar!
            </p>
        </div>
    </div>

    <svg class="size-6 shrink-0 stroke-[#FF2D20]" xmlns="http://www.w3.org/2000/svg"
        fill="none" viewBox="0 0 24 24" stroke-width="1.5">
        <path stroke-linecap="round" stroke-linejoin="round"
            d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75" />
    </svg>
</div>
</div>
<script>
    function initMap() {
        const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 12,
            center: { lat: -25.363, lng: 131.044 },
        });

        const markers = [];

        @foreach ($users as $user)
            var userLat = parseFloat({{ $user->latitud }});
            var userLng = parseFloat({{ $user->longitud }});

            // Solo crea marcadores si las coordenadas son números finitos
            if (isFinite(userLat) && isFinite(userLng)) {
                    var marker = new google.maps.Marker({
                    position: {
                        lat: userLat,
                        lng: userLng
                    },
                    map: map
                });

                var infoWindow = new google.maps.InfoWindow({
                    content: '<h1>{{ $user->name }}</h1>' +
                        '<br>' + '<h2>{{ $user->phone }}</h2>' +
                        '<br>' + '<h3>{{ $user->email }}</h3>'
                });

                marker.addListener('click', function() {
                    infoWindow.open(map, marker);
                });

                markers.push(marker); // Añade el marcador al array de marcadores
            }
        @endforeach

        // Añadir funcionalidad de búsqueda
        const input = document.getElementById('search-input');
        const searchBox = new google.maps.places.SearchBox(input);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

        map.addListener('bounds_changed', function() {
            searchBox.setBounds(map.getBounds());
        });

        searchBox.addListener('places_changed', function() {
            const places = searchBox.getPlaces();

            if (places.length == 0) {
                return;
            }

            // Limpiar marcadores antiguos
            markers.forEach(marker => marker.setMap(null));
            markers.length = 0;

            // Para cada lugar, obtener el nombre y la ubicación
            const bounds = new google.maps.LatLngBounds();
            places.forEach(place => {
                if (!place.geometry || !place.geometry.location) {
                    console.log("Returned place contains no geometry");
                    return;
                }

                const marker = new google.maps.Marker({
                    map: map,
                    title: place.name,
                    position: place.geometry.location,
                });

                markers.push(marker);

                if (place.geometry.viewport) {
                    bounds.union(place.geometry.viewport);
                } else {
                    bounds.extend(place.geometry.location);
                }
            });
            map.fitBounds(bounds);
        });
    }

    function handleLocationError(browserHasGeolocation, pos) {
        const infoWindow = new google.maps.InfoWindow({
            position: pos,
            content: browserHasGeolocation ?
                "Error: El servicio de geolocalización falló." :
                "Error: Tu navegador no soporta geolocalización.",
        });
        infoWindow.open(map);
    }

    // Cargar el script de Google Maps y llamar a la función initMap
    function loadScript() {
        const script = document.createElement('script');
        script.src = `https://maps.googleapis.com/maps/api/js?key=AIzaSyA7__rpQc2QgADzTtK-kzOWNuBe5X7csKo&libraries=places&callback=initMap`;
        script.async = true;
        document.head.appendChild(script);
    }

    window.onload = loadScript;
</script>
