<x-app-layout>
    <x-slot name="header">
        <h2 class="inline text-xl font-semibold leading-tight text-gray-800 ">
            {{ __('Reparacion') }}
        </h2>
    </x-slot>


    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <div> <h1> <strong> ID:</strong> {{  $reparacion->id }} </h1> </div>
                    <div> <h1> <strong> Estado:</strong> {{  $reparacion->Estado }} </h1> </div>

                    <div> <h1> <strong> MODELO:</strong> {{ $reparacion->tablas->Modelo }} </h1> </div>
                    <div> <h1> <strong> MARCA:</strong> {{ $reparacion->tablas->Marca }} </h1> </div>
                    <div> <h1> <strong> COLOR:</strong> {{ $reparacion->tablas->Color }} </h1> </div>
                    <div> <h1> <strong> CLIENTE:</strong> {{ $reparacion->clientes->Nombre. ' '. $reparacion->clientes->Apellido }} </h1> </div>




                </div>
            </div>
        </div>
    </div>

</x-app-layout>
