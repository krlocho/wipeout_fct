<x-app-layout>
    <x-slot name="header">
        <h2 class="inline text-xl font-semibold leading-tight text-gray-800 ">
            {{ __('Reparaciones') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <table id="tabla" class="w-full table-auto">
                        <div class="grid justify-items-end">
                            <a href='{{ url('reparaciones/create') }}'
                                class="px-4 py-1 mb-2 font-semibold font-bold leading-tight text-white text-gray-800 bg-green-600 rounded-full right-20 hover:bg-green-700">
                                Nueva </a>
                        </div>

                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-center text-gray-900 dark:text-white">Id</th>
                                <th class="px-4 py-2 text-center text-gray-900 dark:text-white">Tabla</th>
                                <th class="px-4 py-2 text-center text-gray-900 dark:text-white">Cliente</th>
                                <th class="px-4 py-2 text-center text-gray-900 dark:text-white">Reparacion</th>
                                <th class="px-4 py-2 text-center text-gray-900 dark:text-white">LLegada</th>
                                <th class="px-4 py-2 text-center text-gray-900 dark:text-white">Salida</th>
                                <th class="px-4 py-2 text-center text-gray-900 dark:text-white">Estado</th>
                                <th class="px-4 py-2 text-center text-gray-900 dark:text-white">Precio</th>
                                <th class="px-4 py-2 text-center text-gray-900 dark:text-white">Observaciones</th>
                                <th class="px-4 py-2 text-center text-gray-900 dark:text-white"></th>
                                <th class="px-4 py-2 text-center text-gray-900 dark:text-white"></th>
                                <th class="px-4 py-2 text-center text-gray-900 dark:text-white"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reparaciones as $reparacion)

                                    <tr>
                                        <td class="px-4 py-2 text-center text-gray-900 border dark:text-white">{{ $reparacion->id }}</td>
                                        <td class="px-4 py-2 text-center text-gray-900 border dark:text-white">{{ $reparacion->tablas->Modelo }}</td>
                                        <td class="px-4 py-2 text-center text-gray-900 border dark:text-white">{{ $reparacion->get_cliente_name()}}</td>
                                        <td class="px-4 py-2 text-center text-gray-900 border dark:text-white">{{ $reparacion->Reparacion }}</td>
                                        <td class="px-4 py-2 text-center text-gray-900 border dark:text-white">{{ $reparacion->Fecha_llegada }}</td>
                                        <td class="px-4 py-2 text-center text-gray-900 border dark:text-white">{{ $reparacion->Fecha_salida }}</td>
                                        <td class="px-4 py-2 text-center text-gray-900 border dark:text-white">{{ $reparacion->Estado }}</td>
                                        <td class="px-4 py-2 text-center text-gray-900 border dark:text-white">{{ $reparacion->Precio }}</td>
                                        <td class="px-4 py-2 text-center text-gray-900 border dark:text-white">{{ $reparacion->Observaciones }}</td>
                                        <td class="px-4 py-2 text-center text-gray-900 border dark:text-white">
                                            <a href='{{ url('reparaciones/pdf') }}'
                                                class="px-4 py-1 mb-2 font-semibold font-bold leading-tight text-white text-gray-800 bg-green-600 rounded-full right-20 hover:bg-green-700">
                                                pdf </a>
                                        </td>

                                        <td class="px-4 py-2 text-center text-gray-900 border dark:text-white">
                                            <form action="{{ url('/reparaciones/' . $reparacion->id . '/edit') }}">
                                                <button
                                                    class="px-4 py-1 font-semibold bg-transparent border rounded text-neutral-900 border-neutral-900 hover:bg-neutral-900 hover:text-white hover:border-transparent">
                                                    Editar </button>
                                            </form>
                                        </td>
                                        <td class="px-4 py-2 text-center text-gray-900 border dark:text-white">
                                            <form action="{{ url('/reparaciones/' . $reparacion->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button
                                                    class="px-4 py-1 font-bold text-white bg-red-600 rounded-full hover:bg-red-700">
                                                    Borrar</button>
                                            </form>
                                        </td>
                                    </tr>

                            @endforeach

                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>



</x-app-layout>
