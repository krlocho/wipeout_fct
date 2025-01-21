
<x-app-layout>
    <x-slot name="header" >
            <h2 class="inline text-xl font-semibold leading-tight text-gray-800 ">
                {{ __('Editar Cliente') }}
            </h2>
    </x-slot>
    <form action="{{url('/clientes/'.$cliente->id)}}" method="POST">
    @csrf
    @method('PATCH')

    @include('cliente.form')

</form>
</x-app-layout>

