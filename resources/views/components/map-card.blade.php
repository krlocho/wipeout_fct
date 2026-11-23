@props(['users']) {{-- Declare users property passed to component --}}
<div id="docs-card" class="flex flex-col items-start gap-6 overflow-hidden rounded-lg bg-white p-6 shadow-[0px_1px_5px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 md:row-span-3 lg:p-10 lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800"> {{-- Main card container --}}
    <div id="screenshot-container" class="relative flex items-stretch flex-1 w-full min-h-[320px] rounded-lg overflow-hidden border border-gray-200 dark:border-zinc-800"> {{-- Map wrapper --}}
        @php // PHP block to check if Google Maps API key is configured
            $google_maps_key = config('services.google.maps_api_key'); // Fetch configured Google Maps API key
        @endphp {{-- End PHP block --}}
        @if (!empty($google_maps_key)) {{-- Check if API key is provided --}}
            <input id="search-input" class="absolute top-0 left-0 z-20 flex px-3 py-2 m-3 text-sm text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#FF2D20]" type="text" placeholder="Buscar localidad o taller..." /> {{-- Search input --}}
            <div id="map" class="w-full h-full min-h-[320px]"></div> {{-- Google map canvas div --}}
        @else {{-- Render informative fallback if key is not configured --}}
            <div class="flex flex-col items-center justify-center w-full h-full p-8 text-center bg-gray-100 dark:bg-zinc-800/50"> {{-- Placeholder container --}}
                <svg class="size-10 mb-3 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"> {{-- Map pin icon --}}
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /> {{-- Pin head circle --}}
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" /> {{-- Pin body path --}}
                </svg> {{-- Close SVG --}}
                <p class="font-medium text-gray-700 dark:text-gray-300">Directorio de Talleres en vivo</p> {{-- Fallback title --}}
                <p class="text-xs text-gray-500 max-w-sm mt-1">Configura GOOGLE_MAPS_API_KEY en tu entorno para activar la navegación interactiva de talleres.</p> {{-- Instructions --}}
            </div> {{-- Close placeholder --}}
        @endif {{-- Close key check conditional --}}
    </div> {{-- Close map wrapper container --}}
    <div class="relative flex items-center gap-6 lg:items-end w-full"> {{-- Card footer container --}}
        <div id="docs-card-content" class="flex items-start gap-4"> {{-- Content column --}}
            <div class="flex size-12 shrink-0 items-center justify-center rounded-full bg-[#FF2D20]/10 sm:size-14"> {{-- Icon badge wrapper --}}
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="fill-[#FF2D20]"> {{-- Map folded icon --}}
                    <path d="m21.447 6.105-6-3a1 1 0 0 0-.895 0L9 5.882 3.447 3.105A1 1 0 0 0 2 4v13c0 .379.214.725.553.895l6 3a1 1 0 0 0 .895 0L15 18.118l5.553 2.776a.992.992 0 0 0 .972-.043c.295-.183.475-.504.475-.851V7c0-.379-.214-.725-.553-.895zM10 7.618l4-2v10.764l-4 2V7.618zm-6-2 4 2v10.764l-4-2V5.618zm16 12.764-4-2V5.618l4 2v10.764z"></path> {{-- Map icon path --}}
                </svg> {{-- Close icon --}}
            </div> {{-- Close icon wrapper --}}
            <div> {{-- Text block --}}
                <h2 class="text-xl font-semibold text-black dark:text-white">Talleres certificados</h2> {{-- Card title --}}
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Encuentra tu taller especializado más cercano y lleva tu tabla directamente a manos de artesanos locales.</p> {{-- Card description --}}
            </div> {{-- Close text block --}}
        </div> {{-- Close content wrapper --}}
    </div> {{-- Close footer container --}}
</div> {{-- Close card element --}}
@if (!empty($google_maps_key)) {{-- Script block rendered only if API key exists --}}
<script> {{-- Opening script tag --}}
    function init_workshop_map() { // Function to initialize Google Map with safe markers
        const map_element = document.getElementById("map"); // Get map canvas DOM container
        if (!map_element) return; // Exit early if container is missing
        const workshops_data = @json($users); // Safely parse workshop records into JSON
        const map_instance = new google.maps.Map(map_element, { // Instantiate Google map
            zoom: 6, // Default country-level zoom level
            center: { lat: 43.3, lng: -4.0 }, // Center around northern coastline
        }); // Close map initialization options
        workshops_data.forEach(function(workshop) { // Loop through workshop objects
            const lat_val = parseFloat(workshop.latitud); // Parse latitude float safely
            const lng_val = parseFloat(workshop.longitud); // Parse longitude float safely
            if (!isNaN(lat_val) && !isNaN(lng_val)) { // Ensure numerical coordinate validity
                const marker = new google.maps.Marker({ // Instantiate location marker
                    position: { lat: lat_val, lng: lng_val }, // Marker coordinates
                    map: map_instance, // Associate with map instance
                    title: workshop.name // Set accessible title
                }); // Close marker constructor
                const info_window = new google.maps.InfoWindow({ // Create popup information window
                    content: '<div class="p-2 font-sans font-semibold text-gray-900">' + workshop.name + '</div>' // Safe content without PII leak
                }); // Close info window
                marker.addListener('click', function() { // Add click listener to show info window
                    info_window.open(map_instance, marker); // Open popup on marker
                }); // Close listener callback
            } // Close coordinate validation check
        }); // Close loop over workshops
    } // End of init_workshop_map function
    function load_maps_script() { // Load Google Maps API script dynamically
        const script_tag = document.createElement('script'); // Create script tag element
        script_tag.src = `https://maps.googleapis.com/maps/api/js?key={{ $google_maps_key }}&libraries=places&callback=init_workshop_map`; // Secure URL with injected key
        script_tag.async = true; // Asynchronous script loading
        document.head.appendChild(script_tag); // Append script to head element
    } // End of load_maps_script function
    window.addEventListener('DOMContentLoaded', load_maps_script); // Trigger loading once DOM is ready
</script> {{-- Closing script tag --}}
@endif {{-- End script condition --}}
