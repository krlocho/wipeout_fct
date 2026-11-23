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
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4"> {{-- Name fields row --}}
        <div> {{-- First name container --}}
            <label for="Nombre" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nombre *</label> {{-- Label --}}
            <input type="text" name="Nombre" id="Nombre" required value="{{ old('Nombre', $cliente->Nombre ?? '') }}" placeholder="Ej. Juan" class="w-full rounded-lg border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white text-sm focus:ring-[#FF2D20] focus:border-[#FF2D20]" /> {{-- Input --}}
        </div> {{-- Close first name container --}}
        <div> {{-- Last name container --}}
            <label for="Apellido" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Apellido</label> {{-- Label --}}
            <input type="text" name="Apellido" id="Apellido" value="{{ old('Apellido', $cliente->Apellido ?? '') }}" placeholder="Ej. Pérez" class="w-full rounded-lg border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white text-sm focus:ring-[#FF2D20] focus:border-[#FF2D20]" /> {{-- Input --}}
        </div> {{-- Close last name container --}}
    </div> {{-- Close name row --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4"> {{-- Contact info row --}}
        <div> {{-- Phone container --}}
            <label for="Telefono" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Teléfono / WhatsApp *</label> {{-- Label --}}
            <input type="text" name="Telefono" id="Telefono" required value="{{ old('Telefono', $cliente->Telefono ?? '') }}" placeholder="+34 600 000 000" class="w-full rounded-lg border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white text-sm focus:ring-[#FF2D20] focus:border-[#FF2D20]" /> {{-- Input --}}
        </div> {{-- Close phone container --}}
        <div> {{-- Email container --}}
            <label for="Email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email</label> {{-- Label --}}
            <input type="email" name="Email" id="Email" value="{{ old('Email', $cliente->Email ?? '') }}" placeholder="juan@ejemplo.com" class="w-full rounded-lg border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white text-sm focus:ring-[#FF2D20] focus:border-[#FF2D20]" /> {{-- Input --}}
        </div> {{-- Close email container --}}
    </div> {{-- Close contact row --}}
    <div> {{-- Address container --}}
        <label for="Direccion" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Dirección</label> {{-- Label --}}
        <input type="text" name="Direccion" id="Direccion" value="{{ old('Direccion', $cliente->Direccion ?? '') }}" placeholder="Calle, localidad o playa habitual" class="w-full rounded-lg border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white text-sm focus:ring-[#FF2D20] focus:border-[#FF2D20]" /> {{-- Input --}}
    </div> {{-- Close address container --}}
    <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200 dark:border-zinc-800"> {{-- Actions bar --}}
        <a href="{{ route('clientes.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 dark:bg-zinc-800 dark:text-gray-300">Cancelar</a> {{-- Cancel button --}}
        <button type="submit" class="px-5 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 shadow-sm transition">Guardar Cliente</button> {{-- Submit button --}}
    </div> {{-- Close actions bar --}}
</div> {{-- Close vertical stack container --}}
