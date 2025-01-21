<div class="py-12">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <table id="tabla">
                    <div class="grid ">

                        <label for="Tabla_id">
                            Tabla</label>
                        <select name="Tabla_id" id="Tabla_id"class="rounded-lg">

                            @foreach ($tablas as $tabla)
                                <option value="{{ isset($tabla->id) ? $tabla->id : '' }}">{{ $tabla->Modelo }}</option>
                            @endforeach

                        </select>
                        <br>
                        <label for="Cliente_id">Cliente</label>
                        <select name="Cliente_id" id="Cliente_id" class="rounded-lg">

                            @foreach ($clientes as $cliente)
                                <option value="{{ $cliente->id }}">{{ $cliente->Nombre . ' ' . $cliente->Apellido }}
                                </option>
                            @endforeach

                        </select>
                        <br>
                        <label for="Reparacion">Reparacion</label>
                        <input class="rounded-lg" type="text" name="Reparacion" id="Reparacion"
                            value="{{ $reparacion->Reparacion ?? '' }}">
                        <br>
                        <label for="Fecha_llegada">Fecha de llegada</label>
                        <input class="rounded-lg" type="date" name="Fecha_llegada" id="Fecha_llegada"
                            value="{{ $reparacion->Fecha_llegada ?? date('Y-m-d')  }}">
                        <br>
                        <label for="Fecha_salida">Fecha de salida</label>
                        <input class="rounded-lg" type="date" name="Fecha_salida" id="Fecha_salida"
                            value="{{ $reparacion->Fecha_salida ?? '' }}">
                        <br>
                        <label for="Estado">Estado</label>
                        <select name="Estado" id="Estado"class="rounded-lg">

                            <option value="En Proceso">En Proceso</option>
                            <option value="Sellado">Sellado</option>
                            <option value="Terminado">Terminado</option>

                        </select>
                        <br>
                        <label for="Precio">Precio</label>
                        <input class="rounded-lg" type="text" name="Precio" id="Precio"
                            value="{{ $reparacion->Precio ?? '' }}">
                        <br>
                        <label for="Observaciones">Observaciones</label>
                        <input class="rounded-lg" type="text" name="Observaciones" id="Observaciones"
                            value="{{ $reparacion->Observaciones ?? '' }}">
                        <br>

                        <input
                            class="px-4 py-1 mb-2 font-semibold leading-tight text-white bg-green-600 rounded-full grid-justify-items-end right-20 hover:bg-green-700"
                            type="submit" value="Enviar">




                    </div>
            </div>
        </div>
    </div>
