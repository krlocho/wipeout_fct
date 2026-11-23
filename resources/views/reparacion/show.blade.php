<x-app-layout> {{-- Main application layout wrapper --}}
    <x-slot name="header"> {{-- Header slot --}}
        <div class="flex items-center justify-between"> {{-- Header flex container --}}
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">{{ __('Detalles de la Reparación') }} <span class="font-mono text-sm font-normal text-gray-500">({{ $reparacion->tracking_code }})</span></h2> {{-- Title with code --}}
            <div class="flex gap-2"> {{-- Action links flex --}}
                <a href="{{ route('reparaciones.track', $reparacion->tracking_code) }}" target="_blank" class="px-3 py-1.5 text-xs font-medium text-[#FF2D20] bg-red-50 rounded-lg hover:bg-red-100 dark:bg-red-950/30">Portal Cliente ↗</a> {{-- External tracker --}}
                <a href="{{ route('reparaciones.edit', $reparacion->id) }}" class="px-3 py-1.5 text-xs font-medium text-white bg-green-600 rounded-lg hover:bg-green-700">Editar</a> {{-- Edit button --}}
            </div> {{-- Close action links --}}
        </div> {{-- Close header flex --}}
    </x-slot> {{-- Close header slot --}}
    <div class="py-12"> {{-- Content spacing container --}}
        <div class="mx-auto max-w-4xl sm:px-6 lg:px-8"> {{-- Width constraint wrapper --}}
            <div class="overflow-hidden bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 sm:p-8 space-y-6"> {{-- Card container --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 border-b border-gray-100 dark:border-gray-700 pb-6"> {{-- Two-column summary grid --}}
                    <div> {{-- Left column --}}
                        <span class="text-xs font-medium text-gray-400 uppercase tracking-wider">Código de Seguimiento</span> {{-- Label --}}
                        <p class="text-2xl font-bold font-mono text-[#FF2D20]">{{ $reparacion->tracking_code }}</p> {{-- Tracking code text --}}
                    </div> {{-- Close left column --}}
                    <div> {{-- Right column --}}
                        <span class="text-xs font-medium text-gray-400 uppercase tracking-wider">Estado Actual</span> {{-- Label --}}
                        <p class="text-lg font-semibold text-gray-800 dark:text-gray-200 mt-1">{{ $reparacion->Estado }}</p> {{-- Status string --}}
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
                <div class="pt-4 border-t border-gray-100 dark:border-gray-700 space-y-2"> {{-- Damage and price section --}}
                    <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300">Trabajo a Realizar</h3> {{-- Subtitle --}}
                    <p class="text-sm text-gray-800 dark:text-gray-200">{{ $reparacion->Reparacion }}</p> {{-- Damage description --}}
                    @if ($reparacion->Observaciones) {{-- Check observations --}}
                        <p class="text-xs text-gray-500 bg-gray-50 dark:bg-zinc-800/50 p-3 rounded-lg">{{ $reparacion->Observaciones }}</p> {{-- Observations note --}}
                    @endif {{-- Close observations check --}}
                </div> {{-- Close section --}}
            </div> {{-- Close card --}}
        </div> {{-- Close container --}}
    </div> {{-- Close spacing --}}
</x-app-layout> {{-- Close layout --}}
