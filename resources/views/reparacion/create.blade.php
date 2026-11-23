<x-app-layout> {{-- Main application layout wrapper --}}
    <x-slot name="header"> {{-- Header slot --}}
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">{{ __('Nueva Orden de Reparación') }}</h2> {{-- Title --}}
    </x-slot> {{-- Close header slot --}}
    <div class="py-12"> {{-- Content spacing container --}}
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8"> {{-- Width constraint wrapper --}}
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 sm:p-8 border border-gray-100 dark:border-gray-700"> {{-- Card container --}}
                <form action="{{ route('reparaciones.store') }}" method="POST" enctype="multipart/form-data"> {{-- Creation form with file support --}}
                    @csrf {{-- CSRF security directive --}}
                    @include('reparacion.form') {{-- Form fields partial --}}
                </form> {{-- Close form --}}
            </div> {{-- Close card --}}
        </div> {{-- Close container --}}
    </div> {{-- Close spacing --}}
</x-app-layout> {{-- Close layout --}}
