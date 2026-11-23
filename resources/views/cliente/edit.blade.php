<x-app-layout> {{-- Main application layout wrapper --}}
    <x-slot name="header"> {{-- Header slot --}}
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">{{ __('Editar Cliente') }}</h2> {{-- Title --}}
    </x-slot> {{-- Close header slot --}}
    <div class="py-12"> {{-- Content spacing container --}}
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8"> {{-- Width constraint wrapper --}}
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 sm:p-8 border border-gray-100 dark:border-gray-700"> {{-- Card container --}}
                <form action="{{ route('clientes.update', $cliente->id) }}" method="POST"> {{-- Update form --}}
                    @csrf {{-- CSRF security directive --}}
                    @method('PATCH') {{-- HTTP PATCH verb directive --}}
                    @include('cliente.form') {{-- Form fields partial --}}
                </form> {{-- Close form --}}
            </div> {{-- Close card --}}
        </div> {{-- Close container --}}
    </div> {{-- Close spacing --}}
</x-app-layout> {{-- Close layout --}}
