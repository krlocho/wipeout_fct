<div class="py-12">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="grid ">

                    <label for="Nombre">Nombre</label>
                    <input class="rounded-lg" type="text" name="Nombre" id="Nombre"
                        value="{{ $cliente->Nombre ?? '' }}">
                    <br>
                    <label for="Apellido">Apellido</label>
                    <input class="rounded-lg" type="text" name="Apellido" id="Apellido"
                        value="{{ $cliente->Apellido ?? '' }}">
                        <br>
                    <label for="Direccion">Direccion</label>
                    <input class="rounded-lg" type="text" name="Direccion" id="Direccion"
                        value="{{ $cliente->Direccion ?? '' }}">
                    <br>
                    <label for="Telefono">Telefono</label>
                    <input class="rounded-lg" type="text" name="Telefono" id="Telefono"
                        value="{{ $cliente->Telefono ?? '' }}">
                    <br>
                    <label for="Email">Email</label>
                    <input class="rounded-lg" type="text" name="Email" id="Email"
                        value="{{ $cliente->Email ?? '' }}">
                    <br>

                    <input
                        class="px-4 py-1 mb-2 font-semibold font-bold leading-tight text-white text-gray-800 bg-green-600 rounded-full grid-justify-items-end right-20 hover:bg-green-700"
                        type="submit" value="Enviar">




                </div>
            </div>
        </div>
    </div>
