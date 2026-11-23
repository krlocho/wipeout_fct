<x-app-layout> {{-- Main authenticated application layout component --}}
    <x-slot name="header"> {{-- Layout header slot --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4"> {{-- Header flex container --}}
            <div> {{-- Title wrapper --}}
                <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">{{ __('Tablero de Taller (Kanban)') }}</h2> {{-- Section heading --}}
                <p class="text-xs text-gray-500 mt-0.5">Control visual del flujo de trabajo y estado de secado/reparación de cada tabla.</p> {{-- Subtitle --}}
            </div> {{-- Close title wrapper --}}
            <div class="flex items-center gap-3"> {{-- Header action buttons --}}
                <a href="{{ route('reparaciones.index') }}" class="px-3 py-1.5 text-xs font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 dark:bg-zinc-800 dark:text-gray-300 rounded-lg transition">Ver Vista Tabla</a> {{-- Switch view link --}}
                <a href="{{ route('reparaciones.create') }}" class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 transition duration-150 shadow-sm">+ Nueva Reparación (Intake)</a> {{-- Quick intake button --}}
            </div> {{-- Close action buttons --}}
        </div> {{-- Close flex container --}}
    </x-slot> {{-- Close header slot --}}
    <div class="py-8"> {{-- Content padding container --}}
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8"> {{-- Width constraint wrapper --}}
            @if (session('success')) {{-- Check for success flash notification --}}
                <div class="mb-6 p-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-950/30 dark:text-green-300">{{ session('success') }}</div> {{-- Alert message --}}
            @endif {{-- Close flash conditional --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-start"> {{-- Kanban 3 columns responsive grid --}}
                <div class="bg-gray-100/70 dark:bg-zinc-900 rounded-2xl p-4 border border-gray-200/80 dark:border-zinc-800"> {{-- Column 1: Sin Empezar --}}
                    <div class="flex items-center justify-between pb-3 mb-4 border-b border-gray-200 dark:border-zinc-800"> {{-- Column header --}}
                        <div class="flex items-center gap-2"> {{-- Badge and title --}}
                            <span class="w-2.5 h-2.5 rounded-full bg-red-500"></span> {{-- Red status dot --}}
                            <h3 class="font-bold text-sm text-gray-800 dark:text-gray-200 uppercase tracking-wider">Sin Empezar</h3> {{-- Title --}}
                        </div> {{-- Close badge and title --}}
                        <span class="text-xs font-bold font-mono px-2 py-0.5 rounded-full bg-gray-200 dark:bg-zinc-800 text-gray-700 dark:text-gray-300">{{ $sin_empezar->count() }}</span> {{-- Count pill --}}
                    </div> {{-- Close column header --}}
                    <div class="space-y-4"> {{-- Cards stack --}}
                        @forelse ($sin_empezar as $item) {{-- Loop over unstarted repairs --}}
                            <div class="bg-white dark:bg-zinc-800 p-4 rounded-xl shadow-sm border border-gray-100 dark:border-zinc-700/60 hover:shadow-md transition"> {{-- Repair Card --}}
                                <div class="flex items-center justify-between mb-2"> {{-- Card top row --}}
                                    <div class="flex items-center gap-1.5"> {{-- Left tokens group --}}
                                        <span class="font-mono text-xs font-bold text-[#FF2D20] bg-red-50 dark:bg-red-950/40 px-2 py-0.5 rounded">{{ $item->tracking_code }}</span> {{-- Tracking token --}}
                                        <a href="{{ route('reparaciones.ticket', $item->id) }}" target="_blank" title="Imprimir Ticket & Etiqueta" class="text-xs hover:scale-110 transition">🖨️</a> {{-- Print shortcut --}}
                                    </div> {{-- Close left tokens group --}}
                                    <span class="text-[11px] text-gray-400">{{ $item->Fecha_llegada }}</span> {{-- Arrival date --}}
                                </div> {{-- Close card top row --}}
                                @if (!empty($item->foto_url)) {{-- Check if damage inspection photo exists --}}
                                    <div class="mb-3 rounded-lg overflow-hidden border border-gray-100 dark:border-zinc-700 max-h-32"> {{-- Photo wrapper --}}
                                        <img src="{{ $item->foto_url }}" alt="Foto del daño" class="w-full h-32 object-cover" /> {{-- Render ding photo --}}
                                    </div> {{-- Close photo wrapper --}}
                                @endif {{-- Close photo check --}}
                                <h4 class="font-bold text-sm text-gray-900 dark:text-white leading-snug">{{ $item->tablas?->Modelo ?? 'Tabla' }} <span class="text-xs font-normal text-gray-500">({{ $item->tablas?->Marca ?? '-' }})</span></h4> {{-- Board info --}}
                                <p class="text-xs text-gray-600 dark:text-gray-300 mt-1 line-clamp-2">{{ $item->Reparacion }}</p> {{-- Damage text --}}
                                <div class="flex items-center justify-between text-xs text-gray-400 mt-3 pt-3 border-t border-gray-100 dark:border-zinc-700/50"> {{-- Card footer metadata --}}
                                    <span>👤 {{ $item->clientes?->Nombre ?? 'Cliente' }}</span> {{-- Client name --}}
                                    <span class="font-bold text-gray-900 dark:text-white">{{ $item->Precio ? ($item->Precio . '€') : 'Presupuesto pend.' }}</span> {{-- Price --}}
                                </div> {{-- Close footer metadata --}}
                                <div class="flex items-center justify-between gap-2 mt-3 pt-2"> {{-- Quick move action bar --}}
                                    <a href="{{ route('reparaciones.show', $item->id) }}" class="text-xs text-gray-500 hover:underline">Detalles</a> {{-- Details link --}}
                                    <form action="{{ route('reparaciones.update_estado', $item->id) }}" method="POST"> {{-- Fast move form --}}
                                        @csrf {{-- CSRF token --}}
                                        @method('PATCH') {{-- PATCH method --}}
                                        <input type="hidden" name="estado" value="En Proceso" /> {{-- Target status --}}
                                        <button type="submit" class="px-3 py-1 bg-yellow-500 hover:bg-yellow-600 text-white rounded text-xs font-medium transition">Empezar ➔</button> {{-- Move button --}}
                                    </form> {{-- Close move form --}}
                                </div> {{-- Close action bar --}}
                            </div> {{-- Close Card --}}
                        @empty {{-- Empty state block --}}
                            <p class="text-center text-xs text-gray-400 py-8">No hay tablas pendientes de comenzar.</p> {{-- Empty message --}}
                        @endforelse {{-- Close loop --}}
                    </div> {{-- Close cards stack --}}
                </div> {{-- Close Column 1 --}}

                <div class="bg-gray-100/70 dark:bg-zinc-900 rounded-2xl p-4 border border-gray-200/80 dark:border-zinc-800"> {{-- Column 2: En Proceso --}}
                    <div class="flex items-center justify-between pb-3 mb-4 border-b border-gray-200 dark:border-zinc-800"> {{-- Column header --}}
                        <div class="flex items-center gap-2"> {{-- Badge and title --}}
                            <span class="w-2.5 h-2.5 rounded-full bg-yellow-500"></span> {{-- Yellow status dot --}}
                            <h3 class="font-bold text-sm text-gray-800 dark:text-gray-200 uppercase tracking-wider">En Proceso</h3> {{-- Title --}}
                        </div> {{-- Close badge and title --}}
                        <span class="text-xs font-bold font-mono px-2 py-0.5 rounded-full bg-gray-200 dark:bg-zinc-800 text-gray-700 dark:text-gray-300">{{ $en_proceso->count() }}</span> {{-- Count pill --}}
                    </div> {{-- Close column header --}}
                    <div class="space-y-4"> {{-- Cards stack --}}
                        @forelse ($en_proceso as $item) {{-- Loop over in-progress repairs --}}
                            <div class="bg-white dark:bg-zinc-800 p-4 rounded-xl shadow-sm border border-gray-100 dark:border-zinc-700/60 hover:shadow-md transition"> {{-- Repair Card --}}
                                <div class="flex items-center justify-between mb-2"> {{-- Card top row --}}
                                    <div class="flex items-center gap-1.5"> {{-- Left tokens group --}}
                                        <span class="font-mono text-xs font-bold text-[#FF2D20] bg-red-50 dark:bg-red-950/40 px-2 py-0.5 rounded">{{ $item->tracking_code }}</span> {{-- Tracking token --}}
                                        <a href="{{ route('reparaciones.ticket', $item->id) }}" target="_blank" title="Imprimir Ticket & Etiqueta" class="text-xs hover:scale-110 transition">🖨️</a> {{-- Print shortcut --}}
                                    </div> {{-- Close left tokens group --}}
                                    <span class="text-[11px] text-gray-400">{{ $item->Fecha_llegada }}</span> {{-- Arrival date --}}
                                </div> {{-- Close card top row --}}
                                @if (!empty($item->foto_url)) {{-- Check if damage inspection photo exists --}}
                                    <div class="mb-3 rounded-lg overflow-hidden border border-gray-100 dark:border-zinc-700 max-h-32"> {{-- Photo wrapper --}}
                                        <img src="{{ $item->foto_url }}" alt="Foto del daño" class="w-full h-32 object-cover" /> {{-- Render ding photo --}}
                                    </div> {{-- Close photo wrapper --}}
                                @endif {{-- Close photo check --}}
                                <h4 class="font-bold text-sm text-gray-900 dark:text-white leading-snug">{{ $item->tablas?->Modelo ?? 'Tabla' }} <span class="text-xs font-normal text-gray-500">({{ $item->tablas?->Marca ?? '-' }})</span></h4> {{-- Board info --}}
                                <p class="text-xs text-gray-600 dark:text-gray-300 mt-1 line-clamp-2">{{ $item->Reparacion }}</p> {{-- Damage text --}}
                                <div class="flex items-center justify-between text-xs text-gray-400 mt-3 pt-3 border-t border-gray-100 dark:border-zinc-700/50"> {{-- Card footer metadata --}}
                                    <span>👤 {{ $item->clientes?->Nombre ?? 'Cliente' }}</span> {{-- Client name --}}
                                    <span class="font-bold text-gray-900 dark:text-white">{{ $item->Precio ? ($item->Precio . '€') : '-' }}</span> {{-- Price --}}
                                </div> {{-- Close footer metadata --}}
                                <div class="flex items-center justify-between gap-2 mt-3 pt-2"> {{-- Action buttons bar --}}
                                    <form action="{{ route('reparaciones.update_estado', $item->id) }}" method="POST"> {{-- Move backward form --}}
                                        @csrf {{-- CSRF token --}}
                                        @method('PATCH') {{-- PATCH method --}}
                                        <input type="hidden" name="estado" value="Sin Empezar" /> {{-- Target status --}}
                                        <button type="submit" class="px-2 py-1 text-gray-500 hover:text-gray-700 text-xs">← Pausar</button> {{-- Move button --}}
                                    </form> {{-- Close move form --}}
                                    <form action="{{ route('reparaciones.update_estado', $item->id) }}" method="POST"> {{-- Move forward form --}}
                                        @csrf {{-- CSRF token --}}
                                        @method('PATCH') {{-- PATCH method --}}
                                        <input type="hidden" name="estado" value="Terminado" /> {{-- Target status --}}
                                        <button type="submit" class="px-3 py-1 bg-green-600 hover:bg-green-700 text-white rounded text-xs font-medium transition">Terminar ✓</button> {{-- Move button --}}
                                    </form> {{-- Close move form --}}
                                </div> {{-- Close action bar --}}
                            </div> {{-- Close Card --}}
                        @empty {{-- Empty state block --}}
                            <p class="text-center text-xs text-gray-400 py-8">No hay tablas actualmente en proceso de resina o lijado.</p> {{-- Empty message --}}
                        @endforelse {{-- Close loop --}}
                    </div> {{-- Close cards stack --}}
                </div> {{-- Close Column 2 --}}

                <div class="bg-gray-100/70 dark:bg-zinc-900 rounded-2xl p-4 border border-gray-200/80 dark:border-zinc-800"> {{-- Column 3: Terminado --}}
                    <div class="flex items-center justify-between pb-3 mb-4 border-b border-gray-200 dark:border-zinc-800"> {{-- Column header --}}
                        <div class="flex items-center gap-2"> {{-- Badge and title --}}
                            <span class="w-2.5 h-2.5 rounded-full bg-green-500"></span> {{-- Green status dot --}}
                            <h3 class="font-bold text-sm text-gray-800 dark:text-gray-200 uppercase tracking-wider">Listas para Recoger</h3> {{-- Title --}}
                        </div> {{-- Close badge and title --}}
                        <span class="text-xs font-bold font-mono px-2 py-0.5 rounded-full bg-gray-200 dark:bg-zinc-800 text-gray-700 dark:text-gray-300">{{ $terminado->count() }}</span> {{-- Count pill --}}
                    </div> {{-- Close column header --}}
                    <div class="space-y-4"> {{-- Cards stack --}}
                        @forelse ($terminado as $item) {{-- Loop over finished repairs --}}
                            <div class="bg-white dark:bg-zinc-800 p-4 rounded-xl shadow-sm border border-gray-100 dark:border-zinc-700/60 hover:shadow-md transition"> {{-- Repair Card --}}
                                <div class="flex items-center justify-between mb-2"> {{-- Card top row --}}
                                    <div class="flex items-center gap-1.5"> {{-- Left tokens group --}}
                                        <span class="font-mono text-xs font-bold text-green-700 bg-green-50 dark:bg-green-950/40 px-2 py-0.5 rounded">{{ $item->tracking_code }}</span> {{-- Tracking token --}}
                                        <a href="{{ route('reparaciones.ticket', $item->id) }}" target="_blank" title="Imprimir Ticket & Etiqueta" class="text-xs hover:scale-110 transition">🖨️</a> {{-- Print shortcut --}}
                                    </div> {{-- Close left tokens group --}}
                                    <span class="text-[11px] text-green-600 font-medium">✓ Finalizada</span> {{-- Completed flag --}}
                                </div> {{-- Close card top row --}}
                                @if (!empty($item->foto_url)) {{-- Check if damage inspection photo exists --}}
                                    <div class="mb-3 rounded-lg overflow-hidden border border-gray-100 dark:border-zinc-700 max-h-32"> {{-- Photo wrapper --}}
                                        <img src="{{ $item->foto_url }}" alt="Foto del daño" class="w-full h-32 object-cover" /> {{-- Render ding photo --}}
                                    </div> {{-- Close photo wrapper --}}
                                @endif {{-- Close photo check --}}
                                <h4 class="font-bold text-sm text-gray-900 dark:text-white leading-snug">{{ $item->tablas?->Modelo ?? 'Tabla' }} <span class="text-xs font-normal text-gray-500">({{ $item->tablas?->Marca ?? '-' }})</span></h4> {{-- Board info --}}
                                <p class="text-xs text-gray-600 dark:text-gray-300 mt-1 line-clamp-2">{{ $item->Reparacion }}</p> {{-- Damage text --}}
                                <div class="flex items-center justify-between text-xs text-gray-400 mt-3 pt-3 border-t border-gray-100 dark:border-zinc-700/50"> {{-- Card footer metadata --}}
                                    <span>👤 {{ $item->clientes?->Nombre ?? 'Cliente' }}</span> {{-- Client name --}}
                                    <span class="font-bold text-green-700 dark:text-green-400">{{ $item->Precio ? ($item->Precio . '€') : '-' }}</span> {{-- Price --}}
                                </div> {{-- Close footer metadata --}}
                                <div class="flex flex-wrap items-center justify-between gap-2 mt-3 pt-2"> {{-- Action buttons bar --}}
                                    <form action="{{ route('reparaciones.update_estado', $item->id) }}" method="POST"> {{-- Reopen repair form --}}
                                        @csrf {{-- CSRF token --}}
                                        @method('PATCH') {{-- PATCH method --}}
                                        <input type="hidden" name="estado" value="En Proceso" /> {{-- Target status --}}
                                        <button type="submit" class="px-2 py-1 text-gray-400 hover:text-gray-600 text-xs">Reabrir</button> {{-- Move button --}}
                                    </form> {{-- Close reopen form --}}
                                    <div class="flex items-center gap-1.5"> {{-- Actions group --}}
                                        @if (!empty($item->clientes?->Telefono)) {{-- WhatsApp button conditional --}}
                                            @php // Calculate clean phone and text
                                                $clean_phone = preg_replace('/[^0-9]/', '', $item->clientes->Telefono); // Clean numeric phone
                                                $wa_msg = urlencode("¡Buenas {$item->clientes->Nombre}! Tu tabla {$item->tablas?->Modelo} ya está reparada y lista para recoger en el taller. Código: {$item->tracking_code}. Puedes ver el resultado aquí: " . route('reparaciones.track', ['code' => $item->tracking_code])); // Encode text
                                            @endphp {{-- End PHP computation block --}}
                                            <a href="https://wa.me/{{ $clean_phone }}?text={{ $wa_msg }}" target="_blank" class="px-2 py-1 text-xs font-semibold text-white bg-emerald-600 hover:bg-emerald-700 rounded transition flex items-center gap-1 shadow-sm"> {{-- WhatsApp link --}}
                                                <span>💬</span> Avisar {{-- WhatsApp label --}}
                                            </a> {{-- Close WhatsApp link --}}
                                        @endif {{-- Close WhatsApp check --}}
                                        <a href="{{ route('reparaciones.track', $item->tracking_code) }}" target="_blank" class="px-2 py-1 text-xs font-medium text-[#FF2D20] bg-red-50 hover:bg-red-100 dark:bg-red-950/40 rounded transition">Portal ↗</a> {{-- Tracking portal link --}}
                                    </div> {{-- Close actions group --}}
                                </div> {{-- Close action bar --}}
                            </div> {{-- Close Card --}}
                        @empty {{-- Empty state block --}}
                            <p class="text-center text-xs text-gray-400 py-8">No hay tablas terminadas esperando recogida.</p> {{-- Empty message --}}
                        @endforelse {{-- Close loop --}}
                    </div> {{-- Close cards stack --}}
                </div> {{-- Close Column 3 --}}
            </div> {{-- Close Kanban grid --}}
        </div> {{-- Close width container --}}
    </div> {{-- Close padding container --}}
</x-app-layout> {{-- Close layout --}}
