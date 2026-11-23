<div class="space-y-6" x-data="{ client_mode: '{{ empty($clientes) || $clientes->isEmpty() ? 'new' : 'existing' }}', board_mode: '{{ empty($tablas) || $tablas->isEmpty() ? 'new' : 'existing' }}' }"> {{-- Alpine state manager for quick intake --}}
    @if ($errors->any()) {{-- Display validation error alerts block --}}
        <div class="p-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-950/30 dark:text-red-400"> {{-- Alert container --}}
            <ul class="list-disc pl-5 space-y-1"> {{-- Bulleted list --}}
                @foreach ($errors->all() as $error_msg) {{-- Loop validation errors --}}
                    <li>{{ $error_msg }}</li> {{-- Output single validation message --}}
                @endforeach {{-- Close loop --}}
            </ul> {{-- Close list --}}
        </div> {{-- Close alert --}}
    @endif {{-- Close error block --}}
    <div class="p-4 bg-gray-50 dark:bg-zinc-800/60 rounded-xl border border-gray-200 dark:border-zinc-700"> {{-- Client intake section --}}
        <div class="flex items-center justify-between mb-3"> {{-- Section header with mode switcher --}}
            <label class="text-sm font-bold text-gray-800 dark:text-gray-200">1. Cliente Propietario *</label> {{-- Step label --}}
            <div class="inline-flex rounded-md shadow-sm" role="group"> {{-- Mode switcher buttons group --}}
                <button type="button" @click="client_mode = 'existing'" :class="client_mode === 'existing' ? 'bg-[#FF2D20] text-white' : 'bg-white dark:bg-zinc-700 text-gray-700 dark:text-gray-300'" class="px-2.5 py-1 text-xs font-medium rounded-l-lg border border-gray-200 dark:border-zinc-600 transition">Existente</button> {{-- Existing tab button --}}
                <button type="button" @click="client_mode = 'new'" :class="client_mode === 'new' ? 'bg-[#FF2D20] text-white' : 'bg-white dark:bg-zinc-700 text-gray-700 dark:text-gray-300'" class="px-2.5 py-1 text-xs font-medium rounded-r-lg border border-gray-200 dark:border-zinc-600 border-l-0 transition">+ Nuevo Cliente</button> {{-- New tab button --}}
            </div> {{-- Close button group --}}
        </div> {{-- Close section header --}}
        <div x-show="client_mode === 'existing'"> {{-- Existing client dropdown view --}}
            <select name="Cliente_id" id="Cliente_id" class="w-full rounded-lg border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white text-sm focus:ring-[#FF2D20] focus:border-[#FF2D20]"> {{-- Select element --}}
                <option value="">-- Selecciona un cliente registrado --</option> {{-- Placeholder option --}}
                @foreach ($clientes as $cliente_option) {{-- Loop available clients --}}
                    <option value="{{ $cliente_option->id }}" {{ (old('Cliente_id', $reparacion->Cliente_id ?? '') == $cliente_option->id) ? 'selected' : '' }}>{{ $cliente_option->Nombre }} {{ $cliente_option->Apellido }} ({{ $cliente_option->Telefono }})</option> {{-- Option --}}
                @endforeach {{-- Close loop --}}
            </select> {{-- Close select --}}
        </div> {{-- Close existing client view --}}
        <div x-show="client_mode === 'new'" class="grid grid-cols-1 sm:grid-cols-3 gap-3"> {{-- Quick intake new client inputs --}}
            <input type="text" name="nuevo_cliente_nombre" value="{{ old('nuevo_cliente_nombre') }}" placeholder="Nombre y Apellidos *" class="rounded-lg border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white text-sm focus:ring-[#FF2D20] focus:border-[#FF2D20]" /> {{-- Client name input --}}
            <input type="text" name="nuevo_cliente_telefono" value="{{ old('nuevo_cliente_telefono') }}" placeholder="Teléfono / WhatsApp" class="rounded-lg border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white text-sm focus:ring-[#FF2D20] focus:border-[#FF2D20]" /> {{-- Client phone input --}}
            <input type="email" name="nuevo_cliente_email" value="{{ old('nuevo_cliente_email') }}" placeholder="Email (opcional)" class="rounded-lg border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white text-sm focus:ring-[#FF2D20] focus:border-[#FF2D20]" /> {{-- Client email input --}}
        </div> {{-- Close new client inputs --}}
    </div> {{-- Close client intake section --}}
    <div class="p-4 bg-gray-50 dark:bg-zinc-800/60 rounded-xl border border-gray-200 dark:border-zinc-700"> {{-- Surfboard intake section --}}
        <div class="flex items-center justify-between mb-3"> {{-- Section header with mode switcher --}}
            <label class="text-sm font-bold text-gray-800 dark:text-gray-200">2. Tabla de Surf *</label> {{-- Step label --}}
            <div class="inline-flex rounded-md shadow-sm" role="group"> {{-- Mode switcher buttons group --}}
                <button type="button" @click="board_mode = 'existing'" :class="board_mode === 'existing' ? 'bg-[#FF2D20] text-white' : 'bg-white dark:bg-zinc-700 text-gray-700 dark:text-gray-300'" class="px-2.5 py-1 text-xs font-medium rounded-l-lg border border-gray-200 dark:border-zinc-600 transition">Existente</button> {{-- Existing tab button --}}
                <button type="button" @click="board_mode = 'new'" :class="board_mode === 'new' ? 'bg-[#FF2D20] text-white' : 'bg-white dark:bg-zinc-700 text-gray-700 dark:text-gray-300'" class="px-2.5 py-1 text-xs font-medium rounded-r-lg border border-gray-200 dark:border-zinc-600 border-l-0 transition">+ Nueva Tabla</button> {{-- New tab button --}}
            </div> {{-- Close button group --}}
        </div> {{-- Close section header --}}
        <div x-show="board_mode === 'existing'"> {{-- Existing board dropdown view --}}
            <select name="Tabla_id" id="Tabla_id" class="w-full rounded-lg border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white text-sm focus:ring-[#FF2D20] focus:border-[#FF2D20]"> {{-- Select element --}}
                <option value="">-- Selecciona una tabla del catálogo --</option> {{-- Placeholder option --}}
                @foreach ($tablas as $tabla_option) {{-- Loop available boards --}}
                    <option value="{{ $tabla_option->id }}" {{ (old('Tabla_id', $reparacion->Tabla_id ?? '') == $tabla_option->id) ? 'selected' : '' }}>{{ $tabla_option->Modelo }} - {{ $tabla_option->Marca }} {{ $tabla_option->Color ? '(' . $tabla_option->Color . ')' : '' }}</option> {{-- Option --}}
                @endforeach {{-- Close loop --}}
            </select> {{-- Close select --}}
        </div> {{-- Close existing board view --}}
        <div x-show="board_mode === 'new'" class="grid grid-cols-1 sm:grid-cols-3 gap-3"> {{-- Quick intake new board inputs --}}
            <input type="text" name="nuevo_tabla_modelo" value="{{ old('nuevo_tabla_modelo') }}" placeholder="Modelo (Ej. Shortboard 6.0) *" class="rounded-lg border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white text-sm focus:ring-[#FF2D20] focus:border-[#FF2D20]" /> {{-- Board model input --}}
            <input type="text" name="nuevo_tabla_marca" value="{{ old('nuevo_tabla_marca') }}" placeholder="Marca / Shaper (Ej. Pukas)" class="rounded-lg border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white text-sm focus:ring-[#FF2D20] focus:border-[#FF2D20]" /> {{-- Board brand input --}}
            <input type="text" name="nuevo_tabla_color" value="{{ old('nuevo_tabla_color') }}" placeholder="Color / Quillas (opcional)" class="rounded-lg border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white text-sm focus:ring-[#FF2D20] focus:border-[#FF2D20]" /> {{-- Board color input --}}
        </div> {{-- Close new board inputs --}}
    </div> {{-- Close surfboard intake section --}}
    <div class="p-4 bg-gray-50 dark:bg-zinc-800/60 rounded-xl border border-gray-200 dark:border-zinc-700 space-y-4"> {{-- Damage details section --}}
        <label class="text-sm font-bold text-gray-800 dark:text-gray-200 block">3. Daño & Diagnóstico de Reparación *</label> {{-- Step label --}}
        <div> {{-- Damage description field --}}
            <input type="text" name="Reparacion" id="Reparacion" required value="{{ old('Reparacion', $reparacion->Reparacion ?? '') }}" placeholder="Descripción del daño (ej. Toque profundo en canto izquierdo con entrada de agua)" class="w-full rounded-lg border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white text-sm focus:ring-[#FF2D20] focus:border-[#FF2D20]" /> {{-- Input --}}
        </div> {{-- Close damage field --}}
        <div> {{-- Photo upload field container --}}
            <label class="block text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-400 mb-1">📸 Foto del Toque / Ding (Cámara o Archivo)</label> {{-- Photo label --}}
            <input type="file" name="foto" id="foto" accept="image/*" capture="environment" class="w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-[#FF2D20]/10 file:text-[#FF2D20] hover:file:bg-[#FF2D20]/20 cursor-pointer" /> {{-- File input --}}
            @if (!empty($reparacion->foto_url)) {{-- If existing photo exists in edit mode --}}
                <div class="mt-2 flex items-center gap-3"> {{-- Thumbnail row --}}
                    <img src="{{ $reparacion->foto_url }}" alt="Foto actual" class="w-16 h-16 object-cover rounded-lg border border-gray-200 dark:border-zinc-700" /> {{-- Thumbnail image --}}
                    <span class="text-xs text-gray-400">Foto actual guardada en el sistema. Puedes seleccionar otra para reemplazarla.</span> {{-- Explanatory label --}}
                </div> {{-- Close thumbnail row --}}
            @endif {{-- Close existing photo conditional --}}
        </div> {{-- Close photo field --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3"> {{-- Status, date and price row --}}
            <div> {{-- Arrival date container --}}
                <label for="Fecha_llegada" class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Fecha de Recepción *</label> {{-- Label --}}
                <input type="date" name="Fecha_llegada" id="Fecha_llegada" required value="{{ old('Fecha_llegada', $reparacion->Fecha_llegada ?? date('Y-m-d')) }}" class="w-full rounded-lg border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white text-sm focus:ring-[#FF2D20] focus:border-[#FF2D20]" /> {{-- Input --}}
            </div> {{-- Close arrival date container --}}
            <div> {{-- Status container --}}
                <label for="Estado" class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Fase Inicial *</label> {{-- Label --}}
                <select name="Estado" id="Estado" required class="w-full rounded-lg border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white text-sm focus:ring-[#FF2D20] focus:border-[#FF2D20]"> {{-- Select --}}
                    <option value="Sin Empezar" {{ old('Estado', $reparacion->Estado ?? 'Sin Empezar') === 'Sin Empezar' ? 'selected' : '' }}>🔴 Sin Empezar</option> {{-- Option --}}
                    <option value="En Proceso" {{ old('Estado', $reparacion->Estado ?? '') === 'En Proceso' ? 'selected' : '' }}>🟡 En Proceso (Resina/Lijado)</option> {{-- Option --}}
                    <option value="Terminado" {{ old('Estado', $reparacion->Estado ?? '') === 'Terminado' ? 'selected' : '' }}>🟢 Terminado (Listo)</option> {{-- Option --}}
                </select> {{-- Close select --}}
            </div> {{-- Close status container --}}
            <div> {{-- Price container --}}
                <label for="Precio" class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Presupuesto (€)</label> {{-- Label --}}
                <input type="number" step="0.01" min="0" name="Precio" id="Precio" value="{{ old('Precio', $reparacion->Precio ?? '') }}" placeholder="Ej. 35.00" class="w-full rounded-lg border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white text-sm focus:ring-[#FF2D20] focus:border-[#FF2D20]" /> {{-- Input --}}
            </div> {{-- Close price container --}}
        </div> {{-- Close status, date and price row --}}
        <div> {{-- Observations container --}}
            <label for="Observaciones" class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Notas técnicas para el shaper / taller</label> {{-- Label --}}
            <textarea name="Observaciones" id="Observaciones" rows="2" placeholder="Tipo de fibra (4oz/6oz), resina epoxi/poliéster, notas sobre entrega urgente..." class="w-full rounded-lg border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white text-sm focus:ring-[#FF2D20] focus:border-[#FF2D20]">{{ old('Observaciones', $reparacion->Observaciones ?? '') }}</textarea> {{-- Textarea --}}
        </div> {{-- Close observations container --}}
    </div> {{-- Close damage details section --}}
    <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200 dark:border-zinc-800"> {{-- Actions bar --}}
        <a href="{{ route('reparaciones.kanban') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 dark:bg-zinc-800 dark:text-gray-300">Cancelar</a> {{-- Cancel button --}}
        <button type="submit" class="px-6 py-2.5 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 shadow-sm transition">Guardar y Generar Token QR</button> {{-- Submit button --}}
    </div> {{-- Close actions bar --}}
</div> {{-- Close form root container --}}
