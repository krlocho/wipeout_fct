<x-app-layout>
    <x-slot name="header" >
            <h2 class="inline text-xl font-semibold leading-tight text-gray-800 ">
                {{ __('Crear Cliente') }}
            </h2>








    </x-slot>

<form action="{{url('/clientes')}}" method="POST">
   @csrf
@include('cliente.form')

</form>
</x-app-layout>

