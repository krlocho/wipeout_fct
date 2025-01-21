<x-app-layout>
    <x-slot name="header" >
            <h2 class="inline text-xl font-semibold leading-tight text-gray-800 ">
                {{ __('Crear Reparación') }}
            </h2>








    </x-slot>

<form action="{{url('/reparaciones')}}" method="POST">
   @csrf
@include('reparacion.form')

</form>
</x-app-layout>

