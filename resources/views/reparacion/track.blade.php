<!DOCTYPE html> {{-- HTML5 document declaration --}}
<html lang="es"> {{-- Spanish language document root --}}
<head> {{-- Document metadata header --}}
    <meta charset="utf-8"> {{-- Character encoding UTF-8 --}}
    <meta name="viewport" content="width=device-width, initial-scale=1"> {{-- Viewport settings --}}
    <title>Seguimiento de Reparación | Wipeout</title> {{-- Page title --}}
    <link rel="preconnect" href="https://fonts.bunny.net"> {{-- Preconnect Google fonts --}}
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" /> {{-- Figtree webfont --}}
    @vite(['resources/css/app.css', 'resources/js/app.js']) {{-- Vite compiled stylesheets and scripts --}}
</head> {{-- Close head --}}
<body class="font-sans antialiased bg-gray-50 dark:bg-zinc-950 text-gray-900 dark:text-zinc-100 min-h-screen"> {{-- Body wrapper --}}
    <div class="max-w-3xl mx-auto px-4 py-8 sm:py-12"> {{-- Main container wrapper --}}
        <div class="flex items-center justify-between mb-8 pb-4 border-b border-gray-200 dark:border-zinc-800"> {{-- Header bar --}}
            <a href="{{ route('welcome') }}" class="flex items-center gap-3"> {{-- Back to home link --}}
                <x-application-logo class="w-10 h-10 fill-current text-[#FF2D20]" /> {{-- App branding logo --}}
                <span class="text-xl font-bold tracking-tight">WIPEOUT</span> {{-- Brand wordmark --}}
            </a> {{-- Close brand link --}}
            <a href="{{ route('welcome') }}" class="text-sm font-medium text-gray-500 hover:text-gray-900 dark:hover:text-white transition">← Volver al inicio</a> {{-- Home navigation button --}}
        </div> {{-- Close header bar --}}
        @if ($reparacion) {{-- Condition if repair record is found --}}
            @php // PHP block to compute progress state
                $status_normalized = $reparacion->Estado ?? 'Sin Empezar'; // Normalize status string
                $stage_index = 1; // Stage 1 default for unstarted
                if ($status_normalized === 'En Proceso') { // If in progress
                    $stage_index = 2; // Advance to stage 2
                } elseif ($status_normalized === 'Terminado') { // If finished
                    $stage_index = 3; // Advance to stage 3
                } // End status normalization
                $qr_url = 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=' . urlencode(route('reparaciones.track', ['code' => $reparacion->tracking_code])); // Generate QR code URL
            @endphp {{-- End PHP computation block --}}
            <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-sm border border-gray-200 dark:border-zinc-800 overflow-hidden mb-6"> {{-- Card container --}}
                <div class="p-6 sm:p-8 bg-gradient-to-r from-zinc-900 to-zinc-800 text-white"> {{-- Card top banner --}}
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4"> {{-- Flex row header --}}
                        <div> {{-- Left info col --}}
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-[#FF2D20] text-white uppercase tracking-wider mb-2">Orden de Taller</span> {{-- Order tag --}}
                            <h1 class="text-2xl font-bold tracking-tight font-mono">{{ $reparacion->tracking_code }}</h1> {{-- Tracking code title --}}
                            <p class="text-xs text-zinc-400 mt-1">Registrado el {{ $reparacion->Fecha_llegada }}</p> {{-- Arrival timestamp --}}
                        </div> {{-- Close left info --}}
                        <div class="flex items-center gap-3"> {{-- Right QR code badge --}}
                            <img src="{{ $qr_url }}" alt="Código QR de seguimiento" class="w-16 h-16 rounded-lg bg-white p-1 shadow-sm" /> {{-- Render QR image --}}
                        </div> {{-- Close QR container --}}
                    </div> {{-- Close flex row header --}}
                </div> {{-- Close banner --}}
                <div class="p-6 sm:p-8 border-b border-gray-100 dark:border-zinc-800"> {{-- Progress timeline container --}}
                    <h2 class="text-xs uppercase tracking-wider font-semibold text-gray-400 mb-6">Estado actual del trabajo</h2> {{-- Section heading --}}
                    <div class="relative flex items-center justify-between"> {{-- Progress bar rail --}}
                        <div class="absolute left-0 top-1/2 -translate-y-1/2 h-1 bg-gray-200 dark:bg-zinc-800 w-full z-0"></div> {{-- Background rail --}}
                        <div class="absolute left-0 top-1/2 -translate-y-1/2 h-1 bg-[#FF2D20] z-0 transition-all duration-500" style="width: {{ $stage_index === 1 ? '10%' : ($stage_index === 2 ? '50%' : '100%') }};"></div> {{-- Active fill rail --}}
                        <div class="relative z-10 flex flex-col items-center"> {{-- Step 1 --}}
                            <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs {{ $stage_index >= 1 ? 'bg-[#FF2D20] text-white ring-4 ring-red-100 dark:ring-red-950' : 'bg-gray-200 text-gray-500' }}">1</div> {{-- Node 1 badge --}}
                            <span class="text-xs font-medium mt-2 text-center {{ $stage_index >= 1 ? 'text-gray-900 dark:text-white font-semibold' : 'text-gray-400' }}">Recibida</span> {{-- Step 1 label --}}
                        </div> {{-- Close step 1 --}}
                        <div class="relative z-10 flex flex-col items-center"> {{-- Step 2 --}}
                            <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs {{ $stage_index >= 2 ? 'bg-[#FF2D20] text-white ring-4 ring-red-100 dark:ring-red-950' : 'bg-gray-200 text-gray-500' }}">2</div> {{-- Node 2 badge --}}
                            <span class="text-xs font-medium mt-2 text-center {{ $stage_index >= 2 ? 'text-gray-900 dark:text-white font-semibold' : 'text-gray-400' }}">En Reparación</span> {{-- Step 2 label --}}
                        </div> {{-- Close step 2 --}}
                        <div class="relative z-10 flex flex-col items-center"> {{-- Step 3 --}}
                            <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs {{ $stage_index >= 3 ? 'bg-green-600 text-white ring-4 ring-green-100 dark:ring-green-950' : 'bg-gray-200 text-gray-500' }}">3</div> {{-- Node 3 badge --}}
                            <span class="text-xs font-medium mt-2 text-center {{ $stage_index >= 3 ? 'text-green-600 dark:text-green-400 font-semibold' : 'text-gray-400' }}">Lista para recoger</span> {{-- Step 3 label --}}
                        </div> {{-- Close step 3 --}}
                    </div> {{-- Close progress rail --}}
                </div> {{-- Close timeline container --}}
                <div class="p-6 sm:p-8 grid sm:grid-cols-2 gap-6"> {{-- Details grid --}}
                    <div> {{-- Surfboard details col --}}
                        <h3 class="text-xs uppercase tracking-wider font-semibold text-gray-400 mb-3">Detalles de la Tabla</h3> {{-- Heading --}}
                        <dl class="space-y-2 text-sm"> {{-- Definition list --}}
                            <div class="flex justify-between py-1 border-b border-gray-100 dark:border-zinc-800"> {{-- Definition row --}}
                                <dt class="text-gray-500">Modelo:</dt> {{-- Term --}}
                                <dd class="font-medium text-gray-900 dark:text-white">{{ $reparacion->tablas?->Modelo ?? 'No especificado' }}</dd> {{-- Definition --}}
                            </div> {{-- Close row --}}
                            <div class="flex justify-between py-1 border-b border-gray-100 dark:border-zinc-800"> {{-- Definition row --}}
                                <dt class="text-gray-500">Marca / Shaper:</dt> {{-- Term --}}
                                <dd class="font-medium text-gray-900 dark:text-white">{{ $reparacion->tablas?->Marca ?? 'No especificada' }}</dd> {{-- Definition --}}
                            </div> {{-- Close row --}}
                            <div class="flex justify-between py-1 border-b border-gray-100 dark:border-zinc-800"> {{-- Definition row --}}
                                <dt class="text-gray-500">Color:</dt> {{-- Term --}}
                                <dd class="font-medium text-gray-900 dark:text-white">{{ $reparacion->tablas?->Color ?? '-' }}</dd> {{-- Definition --}}
                            </div> {{-- Close row --}}
                        </dl> {{-- Close list --}}
                    </div> {{-- Close surfboard col --}}
                    <div> {{-- Damage details col --}}
                        <h3 class="text-xs uppercase tracking-wider font-semibold text-gray-400 mb-3">Trabajo Solicitado</h3> {{-- Heading --}}
                        <p class="text-sm font-semibold text-gray-800 dark:text-zinc-200 mb-2">{{ $reparacion->Reparacion }}</p> {{-- Damage string --}}
                        @if (!empty($reparacion->foto_url)) {{-- Check if damage photo exists --}}
                            <div class="mb-3"> {{-- Image container wrapper --}}
                                <img src="{{ asset('storage/' . $reparacion->foto_url) }}" alt="Fotografía del daño" class="w-full max-h-48 object-cover rounded-xl border border-gray-200 dark:border-zinc-700 shadow-sm" /> {{-- Render ding photo --}}
                            </div> {{-- Close image container --}}
                        @endif {{-- Close photo check --}}
                        @if (!empty($reparacion->Observaciones)) {{-- Check observations --}}
                            <p class="text-xs text-gray-500 bg-gray-50 dark:bg-zinc-800/50 p-3 rounded-lg">{{ $reparacion->Observaciones }}</p> {{-- Observations text --}}
                        @endif {{-- Close observations check --}}
                        @if ($reparacion->Fecha_salida) {{-- Check completion date --}}
                            <div class="mt-4 p-3 bg-green-50 dark:bg-green-950/20 text-green-700 dark:text-green-300 text-xs rounded-lg font-medium">Finalizada el: {{ $reparacion->Fecha_salida }}</div> {{-- Completion alert --}}
                        @endif {{-- Close completion check --}}
                    </div> {{-- Close damage col --}}
                </div> {{-- Close grid --}}
            </div> {{-- Close card container --}}
        @else {{-- If no repair is found or initial visit --}}
            <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-sm border border-gray-200 dark:border-zinc-800 p-8 text-center max-w-lg mx-auto"> {{-- Search prompt card --}}
                <div class="w-14 h-14 bg-red-50 dark:bg-red-950/30 text-[#FF2D20] rounded-full flex items-center justify-center mx-auto mb-4"> {{-- Icon circle --}}
                    <svg class="size-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"> {{-- Search SVG --}}
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" /> {{-- SVG path --}}
                    </svg> {{-- Close SVG --}}
                </div> {{-- Close icon wrapper --}}
                <h1 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Rastrear tu tabla de surf</h1> {{-- Card title --}}
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">Introduce el código único de seguimiento entregado por tu taller para consultar el avance del trabajo.</p> {{-- Subtitle --}}
                <form method="GET" action="{{ route('reparaciones.track') }}" class="space-y-3"> {{-- Search lookup form --}}
                    <input type="text" name="code" value="{{ $search_code }}" placeholder="Ejemplo: WP-A491C2" required autofocus class="w-full uppercase font-mono tracking-widest text-center text-lg p-3 rounded-lg border border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-[#FF2D20] focus:outline-none" /> {{-- Input box --}}
                    <button type="submit" class="w-full py-3 px-4 bg-[#FF2D20] hover:bg-[#e0261a] text-white font-medium rounded-lg transition duration-200">Consultar Estado</button> {{-- Action button --}}
                </form> {{-- Close form --}}
                @if (!empty($search_code)) {{-- Display not found error message --}}
                    <div class="mt-4 p-3 text-xs text-red-600 bg-red-50 dark:bg-red-950/30 rounded-lg">No hemos encontrado ninguna reparación asociada al código <strong>{{ $search_code }}</strong>. Por favor, revísalo o contacta con tu taller.</div> {{-- Not found error notification --}}
                @endif {{-- Close not found error --}}
            </div> {{-- Close search card --}}
        @endif {{-- Close repair condition --}}
    </div> {{-- Close container --}}
</body> {{-- Close body --}}
</html> {{-- Close html --}}
