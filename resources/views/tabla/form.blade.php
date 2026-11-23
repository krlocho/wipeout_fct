<div class="space-y-6"> {{-- Main vertical stack for form inputs --}}
    @if ($errors->any()) {{-- Check for validation errors bag --}}
        <div class="p-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-950/30 dark:text-red-400"> {{-- Alert container --}}
            <ul class="list-disc pl-5 space-y-1"> {{-- Bullet list --}}
                @foreach ($errors->all() as $error_msg) {{-- Iterate validation error strings --}}
                    <li>{{ $error_msg }}</li> {{-- Output single validation message --}}
                @endforeach {{-- Close loop --}}
            </ul> {{-- Close list --}}
        </div> {{-- Close alert --}}
    @endif {{-- Close error block --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4"> {{-- Board info two-column grid --}}
        <div> {{-- Model input container --}}
            <label for="Modelo" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Modelo de la tabla *</label> {{-- Label --}}
            <input type="text" name="Modelo" id="Modelo" required value="{{ old('Modelo', $tabla->Modelo ?? '') }}" placeholder="Ej. Shortboard 6'0, Fish retro..." class="w-full rounded-lg border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white text-sm focus:ring-[#FF2D20] focus:border-[#FF2D20]" /> {{-- Input --}}
        </div> {{-- Close model container --}}
        <div> {{-- Brand input container --}}
            <label for="Marca" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Marca / Shaper *</label> {{-- Label --}}
            <input type="text" name="Marca" id="Marca" required value="{{ old('Marca', $tabla->Marca ?? '') }}" placeholder="Ej. Channel Islands, Lost, Pukas..." class="w-full rounded-lg border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white text-sm focus:ring-[#FF2D20] focus:border-[#FF2D20]" /> {{-- Input --}}
        </div> {{-- Close brand container --}}
    </div> {{-- Close two-column grid --}}
    <div> {{-- Color input container --}}
        <label for="Color" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Color / Artwork</label> {{-- Label --}}
        <input type="text" name="Color" id="Color" value="{{ old('Color', $tabla->Color ?? '') }}" placeholder="Ej. Blanco con cantos tintados en azul" class="w-full rounded-lg border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white text-sm focus:ring-[#FF2D20] focus:border-[#FF2D20]" /> {{-- Input --}}
    </div> {{-- Close color container --}}
    <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200 dark:border-zinc-800"> {{-- Actions bar --}}
        <a href="{{ route('tablas.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 dark:bg-zinc-800 dark:text-gray-300">Cancelar</a> {{-- Cancel button --}}
        <button type="submit" class="px-5 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 shadow-sm transition">Guardar Tabla</button> {{-- Submit button --}}
    </div> {{-- Close actions bar --}}
</div> {{-- Close vertical stack container --}}
