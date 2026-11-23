<x-app-layout> {{-- Main application layout wrapper --}}
    <x-slot name="header"> {{-- Header slot --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4"> {{-- Header flex container --}}
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">{{ __('Detalles de la Reparación') }} <span class="font-mono text-sm font-normal text-gray-500">({{ $reparacion->tracking_code }})</span></h2> {{-- Title with code --}}
            <div class="flex flex-wrap items-center gap-2"> {{-- Action links flex --}}
                <a href="{{ route('reparaciones.ticket', $reparacion->id) }}" target="_blank" class="px-3 py-1.5 text-xs font-semibold text-zinc-900 bg-zinc-100 hover:bg-zinc-200 dark:bg-zinc-700 dark:text-white rounded-lg flex items-center gap-1.5 transition"> {{-- Ticket button --}}
                    <span>🖨️</span> Imprimir Ticket & Etiqueta {{-- Button text --}}
                </a> {{-- Close ticket button --}}
                @if (!empty($reparacion->clientes?->Telefono)) {{-- WhatsApp button conditional --}}
                    @php // Calculate clean phone and text
                        $clean_phone = preg_replace('/[^0-9]/', '', $reparacion->clientes->Telefono); // Strip non-numeric chars
                        $wa_msg = urlencode("¡Hola {$reparacion->clientes->Nombre}! Tu tabla {$reparacion->tablas?->Modelo} está en estado '{$reparacion->Estado}' en el taller. Consulta los detalles y fotos aquí: " . route('reparaciones.track', ['code' => $reparacion->tracking_code])); // Encode message
                    @endphp {{-- End PHP computation block --}}
                    <a href="https://wa.me/{{ $clean_phone }}?text={{ $wa_msg }}" target="_blank" class="px-3 py-1.5 text-xs font-semibold text-white bg-emerald-600 hover:bg-emerald-700 rounded-lg flex items-center gap-1.5 transition"> {{-- WhatsApp button --}}
                        <span>💬</span> Avisar por WhatsApp {{-- Button text --}}
                    </a> {{-- Close WhatsApp button --}}
                @endif {{-- Close WhatsApp conditional --}}
                <a href="{{ route('reparaciones.track', $reparacion->tracking_code) }}" target="_blank" class="px-3 py-1.5 text-xs font-medium text-[#FF2D20] bg-red-50 rounded-lg hover:bg-red-100 dark:bg-red-950/30">Portal Cliente ↗</a> {{-- External tracker --}}
                <a href="{{ route('reparaciones.edit', $reparacion->id) }}" class="px-3 py-1.5 text-xs font-medium text-white bg-green-600 rounded-lg hover:bg-green-700">Editar</a> {{-- Edit button --}}
            </div> {{-- Close action links --}}
        </div> {{-- Close header flex --}}
    </x-slot> {{-- Close header slot --}}
    <div class="py-12"> {{-- Content spacing container --}}
        <div class="mx-auto max-w-4xl sm:px-6 lg:px-8"> {{-- Width constraint wrapper --}}
            <div class="overflow-hidden bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 sm:p-8 space-y-6"> {{-- Card container --}}
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 border-b border-gray-100 dark:border-gray-700 pb-6"> {{-- Three-column summary grid --}}
                    <div> {{-- Left column --}}
                        <span class="text-xs font-medium text-gray-400 uppercase tracking-wider">Código de Seguimiento</span> {{-- Label --}}
                        <p class="text-2xl font-bold font-mono text-[#FF2D20]">{{ $reparacion->tracking_code }}</p> {{-- Tracking code text --}}
                    </div> {{-- Close left column --}}
                    <div> {{-- Middle column --}}
                        <span class="text-xs font-medium text-gray-400 uppercase tracking-wider">Estado Actual</span> {{-- Label --}}
                        <p class="text-lg font-semibold text-gray-800 dark:text-gray-200 mt-1">{{ $reparacion->Estado }}</p> {{-- Status string --}}
                    </div> {{-- Close middle column --}}
                    <div> {{-- Right column --}}
                        <span class="text-xs font-medium text-gray-400 uppercase tracking-wider">Presupuesto / Precio</span> {{-- Label --}}
                        <p class="text-lg font-bold text-gray-900 dark:text-white mt-1">{{ $reparacion->Precio ? number_format($reparacion->Precio, 2) . ' €' : 'Pendiente' }}</p> {{-- Price string --}}
                    </div> {{-- Close right column --}}
                </div> {{-- Close summary grid --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6"> {{-- Details two-column grid --}}
                    <div> {{-- Board card column --}}
                        <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Tabla Asociada</h3> {{-- Subtitle --}}
                        <div class="bg-gray-50 dark:bg-zinc-800/50 p-4 rounded-lg text-sm space-y-1"> {{-- Inner box --}}
                            <p><strong>Modelo:</strong> {{ $reparacion->tablas?->Modelo ?? 'No asignado' }}</p> {{-- Board model --}}
                            <p><strong>Marca:</strong> {{ $reparacion->tablas?->Marca ?? '-' }}</p> {{-- Board brand --}}
                            <p><strong>Color:</strong> {{ $reparacion->tablas?->Color ?? '-' }}</p> {{-- Board color --}}
                        </div> {{-- Close inner box --}}
                    </div> {{-- Close board column --}}
                    <div> {{-- Client card column --}}
                        <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Cliente</h3> {{-- Subtitle --}}
                        <div class="bg-gray-50 dark:bg-zinc-800/50 p-4 rounded-lg text-sm space-y-1"> {{-- Inner box --}}
                            <p><strong>Nombre:</strong> {{ $reparacion->clientes ? ($reparacion->clientes->Nombre . ' ' . $reparacion->clientes->Apellido) : 'No asignado' }}</p> {{-- Client name --}}
                            <p><strong>Teléfono:</strong> {{ $reparacion->clientes?->Telefono ?? '-' }}</p> {{-- Client phone --}}
                            <p><strong>Email:</strong> {{ $reparacion->clientes?->Email ?? '-' }}</p> {{-- Client email --}}
                        </div> {{-- Close inner box --}}
                    </div> {{-- Close client column --}}
                </div> {{-- Close details grid --}}
                <div class="pt-4 border-t border-gray-100 dark:border-gray-700 space-y-3"> {{-- Damage and price section --}}
                    <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300">Trabajo a Realizar</h3> {{-- Subtitle --}}
                    <p class="text-sm text-gray-800 dark:text-gray-200">{{ $reparacion->Reparacion }}</p> {{-- Damage description --}}
                    @if (!empty($reparacion->foto_url)) {{-- Damage photo check --}}
                        <div class="mt-3"> {{-- Image container --}}
                            <span class="text-xs text-gray-400 block mb-1">Fotografía del daño:</span> {{-- Label --}}
                            <img src="{{ $reparacion->foto_url }}" alt="Fotografía del daño" class="max-h-64 rounded-xl border border-gray-200 dark:border-zinc-700 object-cover shadow-sm" /> {{-- Render ding photo --}}
                        </div> {{-- Close image container --}}
                    @endif {{-- Close photo check --}}
                    @if ($reparacion->Observaciones) {{-- Check observations --}}
                        <p class="text-xs text-gray-500 bg-gray-50 dark:bg-zinc-800/50 p-3 rounded-lg">{{ $reparacion->Observaciones }}</p> {{-- Observations note --}}
                    @endif {{-- Close observations check --}}
                </div> {{-- Close section --}}
            </div> {{-- Close card --}}
        </div> {{-- Close container --}}
    </div> {{-- Close spacing --}}
</x-app-layout> {{-- Close layout --}}
