
<x-app-layout>
    <x-slot name="header" >
            <h2 class="inline text-xl font-semibold leading-tight text-gray-800 ">
                {{ __('Editar Reparación') }}
            </h2>
    </x-slot>
    <form action="{{url('/reparaciones/'.$reparacion->id)}}" method="POST">
    @csrf
    @method('PATCH')

    @include('reparacion.form')

</form>
</x-app-layout>

