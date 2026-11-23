<x-app-layout> {{-- Main application layout wrapper --}}
    <x-slot name="header"> {{-- Header slot --}}
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">{{ __('Nueva Tabla de Surf') }}</h2> {{-- Title --}}
    </x-slot> {{-- Close header slot --}}
    <div class="py-12"> {{-- Content spacing container --}}
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8"> {{-- Width constraint wrapper --}}
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 sm:p-8 border border-gray-100 dark:border-gray-700"> {{-- Card container --}}
                <form action="{{ route('tablas.store') }}" method="POST"> {{-- Creation form --}}
                    @csrf {{-- CSRF security directive --}}
                    @include('tabla.form') {{-- Form fields partial --}}
                </form> {{-- Close form --}}
            </div> {{-- Close card --}}
        </div> {{-- Close container --}}
    </div> {{-- Close spacing --}}
</x-app-layout> {{-- Close layout --}}
