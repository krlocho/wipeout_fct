<div  class="py-12 ">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="grid ">

                    <label for="Modelo">Modelo</label>
                    <input class="rounded-lg" type="text" name="Modelo" id="Modelo"
                        value="{{ $tabla->Modelo ?? '' }}">
                    <br>
                    <label for="Marca">Marca</label>
                    <input class="rounded-lg" type="text" name="Marca" id="Marca"
                        value="{{ $tabla->Marca ?? '' }}">
                    <br>
                    <label for="Color">Color</label>
                    <input class="rounded-lg" type="text" name="Color" id="Color"
                        value="{{ $tabla->Color ?? '' }}">
                    <br>


                    <input
                        class="px-4 py-1 mb-2 font-semibold font-bold leading-tight text-white text-gray-800 bg-green-600 rounded-full grid-justify-items-end right-20 hover:bg-green-700"
                        type="submit" value="Enviar">




                </div>
            </div>
        </div>
    </div>
