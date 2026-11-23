<x-app-layout> {{-- Main application layout wrapper --}}
    <x-slot name="header"> {{-- Header slot --}}
        <div class="flex items-center justify-between"> {{-- Header flex container --}}
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">{{ __('Editar Reparación') }} <span class="font-mono text-sm font-normal text-gray-500">({{ $reparacion->tracking_code }})</span></h2> {{-- Title --}}
            <a href="{{ route('reparaciones.track', $reparacion->tracking_code) }}" target="_blank" class="text-xs text-[#FF2D20] hover:underline font-mono">Abrir portal cliente ↗</a> {{-- Tracking preview link --}}
        </div> {{-- Close flex --}}
    </x-slot> {{-- Close header slot --}}
    <div class="py-12"> {{-- Content spacing container --}}
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8"> {{-- Width constraint wrapper --}}
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 sm:p-8 border border-gray-100 dark:border-gray-700"> {{-- Card container --}}
                <form action="{{ route('reparaciones.update', $reparacion->id) }}" method="POST" enctype="multipart/form-data"> {{-- Update form with photo support --}}
                    @csrf {{-- CSRF security directive --}}
                    @method('PATCH') {{-- HTTP PATCH verb directive --}}
                    @include('reparacion.form') {{-- Form fields partial --}}
                </form> {{-- Close form --}}
            </div> {{-- Close card --}}
        </div> {{-- Close container --}}
    </div> {{-- Close spacing --}}
</x-app-layout> {{-- Close layout --}}
