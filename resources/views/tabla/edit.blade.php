<x-app-layout>
    <x-slot name="header">
        <h2 class="inline text-xl font-semibold leading-tight text-gray-800 ">
            {{ __('Editar Tabla') }}
        </h2>
    </x-slot>
    <form action="{{ url('/tablas/' . $tabla->id) }}" method="POST">
        @csrf
        @method('PATCH')

        @include('tabla.form')

    </form>
</x-app-layout>
