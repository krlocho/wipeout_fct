<x-app-layout> {{-- Main authenticated application layout component --}}
    <x-slot name="header"> {{-- Layout header slot --}}
        <div class="flex items-center justify-between"> {{-- Header flex container --}}
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">{{ __('Clientes') }}</h2> {{-- Section heading --}}
            <a href="{{ route('clientes.create') }}" class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 transition duration-150 shadow-sm">+ Nuevo Cliente</a> {{-- Create button --}}
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
                                <th class="px-6 py-3">Nombre</th> {{-- Customer name header --}}
                                <th class="px-6 py-3">Teléfono</th> {{-- Customer phone header --}}
                                <th class="px-6 py-3">Email</th> {{-- Customer email header --}}
                                <th class="px-6 py-3">Dirección</th> {{-- Customer address header --}}
                                <th class="px-6 py-3 text-right">Acciones</th> {{-- Actions column header --}}
                            </tr> {{-- Close header row --}}
                        </thead> {{-- Close table head --}}
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700"> {{-- Table body wrapper --}}
                            @forelse ($clientes as $cliente) {{-- Iterate clients or show empty state --}}
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition"> {{-- Data row --}}
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">{{ $cliente->Nombre }} {{ $cliente->Apellido }}</td> {{-- Full name --}}
                                    <td class="px-6 py-4 font-mono">{{ $cliente->Telefono }}</td> {{-- Phone number --}}
                                    <td class="px-6 py-4">{{ $cliente->Email ?? '-' }}</td> {{-- Email address --}}
                                    <td class="px-6 py-4 text-gray-400">{{ $cliente->Direccion ?? '-' }}</td> {{-- Address --}}
                                    <td class="px-6 py-4 text-right whitespace-nowrap"> {{-- Actions column --}}
                                        <div class="flex items-center justify-end gap-2"> {{-- Action buttons flex --}}
                                            <a href="{{ route('clientes.edit', $cliente->id) }}" class="px-3 py-1 text-xs font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300">Editar</a> {{-- Edit link --}}
                                            <form action="{{ route('clientes.destroy', $cliente->id) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar este cliente?');"> {{-- Delete form --}}
                                                @csrf {{-- CSRF token directive --}}
                                                @method('DELETE') {{-- HTTP DELETE verb directive --}}
                                                <button type="submit" class="px-3 py-1 text-xs font-medium text-red-600 bg-red-50 rounded-md hover:bg-red-100 dark:bg-red-950/30 dark:text-red-400">Eliminar</button> {{-- Delete button --}}
                                            </form> {{-- Close delete form --}}
                                        </div> {{-- Close action flex --}}
                                    </td> {{-- Close actions cell --}}
                                </tr> {{-- Close data row --}}
                            @empty {{-- Empty state block --}}
                                <tr> {{-- Empty table row --}}
                                    <td colspan="5" class="px-6 py-8 text-center text-gray-400">No tienes clientes registrados todavía. Haz clic en "Nuevo Cliente" para añadir el primero.</td> {{-- Empty notice --}}
                                </tr> {{-- Close empty row --}}
                            @endforelse {{-- Close loop --}}
                        </tbody> {{-- Close tbody --}}
                    </table> {{-- Close table --}}
                    <div class="mt-4"> {{-- Pagination container --}}
                        {{ $clientes->links() }} {{-- Render pagination links --}}
                    </div> {{-- Close pagination container --}}
                </div> {{-- Close responsive wrapper --}}
            </div> {{-- Close card container --}}
        </div> {{-- Close width container --}}
    </div> {{-- Close padding container --}}
</x-app-layout> {{-- Close application layout --}}
