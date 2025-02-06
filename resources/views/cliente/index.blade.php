<x-app-layout>
    <x-slot name="header" >
            <h2 class="inline text-xl font-semibold leading-tight text-gray-800 ">
                {{ __('Clientes') }}
            </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <table id="tabla" class="w-full table-auto">
                        <div  class="grid justify-items-end">
                        <a href='{{ url("clientes/create") }}' class="px-4 py-1 mb-2 font-semibold font-bold leading-tight text-white text-gray-800 bg-green-600 rounded-full right-20 hover:bg-green-700"> Nueva </a>
                    </div>

                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-center text-gray-900 dark:text-white">Id</th>
                                <th class="px-4 py-2 text-center text-gray-900 dark:text-white">Nombre</th>
                                <th class="px-4 py-2 text-center text-gray-900 dark:text-white">Apellido</th>
                                <th class="px-4 py-2 text-center text-gray-900 dark:text-white">Direccion</th>
                                <th class="px-4 py-2 text-center text-gray-900 dark:text-white">Telefono</th>
                                <th class="px-4 py-2 text-center text-gray-900 dark:text-white">Email</th>
                                <th class="px-4 py-2 text-center text-gray-900 dark:text-white"></th>
                                <th class="px-4 py-2 text-center text-gray-900 dark:text-white"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($clientes as $cliente)

                                <tr>
                                    <td class="px-4 py-2 text-center text-gray-900 border dark:text-white">{{ $cliente->id }}</td>
                                    <td class="px-4 py-2 text-center text-gray-900 border dark:text-white">{{ $cliente->Nombre }} </td>{{-- ->Modelo or 'Sin Autor' --}}
                                    <td class="px-4 py-2 text-center text-gray-900 border dark:text-white">{{ $cliente->Apellido}}</td> {{-- ->Nombre or 'Sin Autor' --}}
                                    <td class="px-4 py-2 text-center text-gray-900 border dark:text-white">{{ $cliente->Direccion}}</td>
                                    <td class="px-4 py-2 text-center text-gray-900 border dark:text-white">{{ $cliente->Telefono}}</td>
                                    <td class="px-4 py-2 text-center text-gray-900 border dark:text-white">{{ $cliente->Email }}</td>
                                    <td class="px-4 py-2 text-center text-gray-900 border dark:text-white">
                                        <form action="{{ url('/clientes/' . $cliente->id . '/edit') }}">
                                            <button
                                                class="px-4 py-1 font-semibold bg-transparent border rounded text-neutral-900 border-neutral-900 hover:bg-neutral-900 hover:text-white hover:border-transparent">
                                                Editar </button>
                                        </form>
                                        </button>
                                    </td>
                                    <td class="px-4 py-2 text-center text-gray-900 border dark:text-white">
                                        <form action="{{ url('/clientes/' . $cliente->id) }}" method="POST">
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


    <script>
        $(document).ready(function() {
            $('#tabla').DataTable({
                columnDefs: [{
                    orderable: false,
                    targets: [6, 7]
                }],


            });
        });
    </script>
</x-app-layout>
