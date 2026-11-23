<x-app-layout> {{-- Main authenticated application layout component --}}
    <x-slot name="header"> {{-- Layout header slot --}}
        <div class="flex items-center justify-between"> {{-- Header flex container --}}
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">{{ __('Reparaciones de Tablas') }}</h2> {{-- Section heading --}}
            <a href="{{ route('reparaciones.create') }}" class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 transition duration-150 shadow-sm">+ Nueva Reparación</a> {{-- Create button --}}
        </div> {{-- Close flex container --}}
    </x-slot> {{-- Close header slot --}}
    <div class="py-12"> {{-- Content padding container --}}
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8"> {{-- Width constraint wrapper --}}
            @if (session('success')) {{-- Check for success flash notification --}}
                <div class="mb-4 p-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-950/30 dark:text-green-300">{{ session('success') }}</div> {{-- Alert message --}}
            @endif {{-- Close flash conditional --}}
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg"> {{-- Table container card --}}
                <div class="p-6 overflow-x-auto"> {{-- Horizontal scroll responsive wrapper --}}
                    <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400"> {{-- Data table element --}}
                        <thead class="text-xs uppercase bg-gray-50 dark:bg-gray-700 text-gray-700 dark:text-gray-300"> {{-- Head wrapper --}}
                            <tr> {{-- Header row --}}
                                <th class="px-4 py-3">Código Tracking</th> {{-- Tracking code header --}}
                                <th class="px-4 py-3">Tabla</th> {{-- Board header --}}
                                <th class="px-4 py-3">Cliente</th> {{-- Customer header --}}
                                <th class="px-4 py-3">Trabajo</th> {{-- Damage work header --}}
                                <th class="px-4 py-3">Estado</th> {{-- Progress status header --}}
                                <th class="px-4 py-3">Llegada</th> {{-- Arrival date header --}}
                                <th class="px-4 py-3">Precio</th> {{-- Price header --}}
                                <th class="px-4 py-3 text-right">Acciones</th> {{-- Actions column header --}}
                            </tr> {{-- Close header row --}}
                        </thead> {{-- Close table head --}}
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700"> {{-- Table body wrapper --}}
                            @forelse ($reparaciones as $reparacion) {{-- Iterate repairs or show empty state --}}
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition"> {{-- Data row --}}
                                    <td class="px-4 py-4 whitespace-nowrap"> {{-- Tracking cell --}}
                                        <a href="{{ route('reparaciones.track', $reparacion->tracking_code) }}" target="_blank" class="font-mono font-bold text-xs bg-red-50 text-[#FF2D20] px-2.5 py-1 rounded-md hover:underline" title="Ver portal público de seguimiento">{{ $reparacion->tracking_code }} ↗</a> {{-- Tracking code pill --}}
                                    </td> {{-- Close tracking cell --}}
                                    <td class="px-4 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">{{ $reparacion->tablas?->Modelo ?? 'Tabla no asignada' }}</td> {{-- Board model --}}
                                    <td class="px-4 py-4 whitespace-nowrap">{{ $reparacion->clientes ? ($reparacion->clientes->Nombre . ' ' . $reparacion->clientes->Apellido) : 'Sin cliente' }}</td> {{-- Client name --}}
                                    <td class="px-4 py-4 max-w-xs truncate" title="{{ $reparacion->Reparacion }}">{{ $reparacion->Reparacion }}</td> {{-- Damage description --}}
                                    <td class="px-4 py-4 whitespace-nowrap"> {{-- Status badge cell --}}
                                        @if ($reparacion->Estado === 'Terminado') {{-- Finished badge --}}
                                            <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-950/40 dark:text-green-300">Terminado</span> {{-- Finished tag --}}
                                        @elseif ($reparacion->Estado === 'En Proceso') {{-- In progress badge --}}
                                            <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-950/40 dark:text-yellow-300">En Curso</span> {{-- In progress tag --}}
                                        @else {{-- Unstarted badge --}}
                                            <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">Sin Empezar</span> {{-- Pending tag --}}
                                        @endif {{-- Close status check --}}
                                    </td> {{-- Close status cell --}}
                                    <td class="px-4 py-4 whitespace-nowrap">{{ $reparacion->Fecha_llegada }}</td> {{-- Arrival date --}}
                                    <td class="px-4 py-4 font-semibold text-gray-900 dark:text-white whitespace-nowrap">{{ $reparacion->Precio ? ($reparacion->Precio . ' €') : '-' }}</td> {{-- Formatted price --}}
                                    <td class="px-4 py-4 text-right whitespace-nowrap"> {{-- Actions column --}}
                                        <div class="flex items-center justify-end gap-2"> {{-- Action buttons flex --}}
                                            <a href="{{ route('reparaciones.edit', $reparacion->id) }}" class="px-3 py-1 text-xs font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300">Editar</a> {{-- Edit link --}}
                                            <form action="{{ route('reparaciones.destroy', $reparacion->id) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar esta reparación?');"> {{-- Delete form --}}
                                                @csrf {{-- CSRF token directive --}}
                                                @method('DELETE') {{-- HTTP DELETE verb directive --}}
                                                <button type="submit" class="px-3 py-1 text-xs font-medium text-red-600 bg-red-50 rounded-md hover:bg-red-100 dark:bg-red-950/30 dark:text-red-400">Eliminar</button> {{-- Delete button --}}
                                            </form> {{-- Close delete form --}}
                                        </div> {{-- Close action flex --}}
                                    </td> {{-- Close actions cell --}}
                                </tr> {{-- Close data row --}}
                            @empty {{-- Empty state block --}}
                                <tr> {{-- Empty table row --}}
                                    <td colspan="8" class="px-6 py-8 text-center text-gray-400">No tienes reparaciones registradas actualmente. Haz clic en "Nueva Reparación" para registrar una tabla.</td> {{-- Empty notice --}}
                                </tr> {{-- Close empty row --}}
                            @endforelse {{-- Close loop --}}
                        </tbody> {{-- Close tbody --}}
                    </table> {{-- Close table --}}
                    <div class="mt-4"> {{-- Pagination container --}}
                        {{ $reparaciones->links() }} {{-- Render pagination links --}}
                    </div> {{-- Close pagination container --}}
                </div> {{-- Close responsive wrapper --}}
            </div> {{-- Close card container --}}
        </div> {{-- Close width container --}}
    </div> {{-- Close padding container --}}
</x-app-layout> {{-- Close application layout --}}
