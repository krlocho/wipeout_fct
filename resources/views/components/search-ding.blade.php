<div class="flex items-start gap-4 rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#FF2D20] lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#FF2D20]"> {{-- Main card container --}}
    <div class="flex size-12 shrink-0 items-center justify-center rounded-full bg-[#FF2D20]/10 sm:size-16"> {{-- Icon circular container --}}
        <svg class="size-6 text-[#FF2D20]" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"> {{-- Search ding surfboard icon --}}
            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" /> {{-- Magnifying glass search path --}}
        </svg> {{-- Close search icon --}}
    </div> {{-- Close icon wrapper --}}
    <div class="flex flex-col gap-3 pt-3 sm:pt-5 w-full"> {{-- Content column wrapper --}}
        <h2 class="text-xl font-semibold text-black dark:text-white">Comprueba el estado de tu tabla</h2> {{-- User friendly headline --}}
        <p class="text-sm text-gray-600 dark:text-gray-400">Introduce el código único de seguimiento entregado por el taller para ver las fotos y avance en tiempo real.</p> {{-- Explanatory subtitle --}}
        <form method="GET" action="{{ route('reparaciones.track') }}" class="flex flex-col sm:flex-row gap-2 mt-2"> {{-- Single-input tracking lookup form --}}
            <input type="text" name="code" id="tracking_code_input" placeholder="Ej. WP-A491C2" required class="w-full uppercase font-mono tracking-wider p-2.5 text-sm rounded-lg border border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-[#FF2D20] focus:outline-none" /> {{-- Unified tracking input --}}
            <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-[#FF2D20] rounded-lg hover:bg-[#e0261a] transition duration-200 shrink-0">Rastrear</button> {{-- Action submission button --}}
        </form> {{-- Close form element --}}
        @if ($errors->any()) {{-- Check for validation or lookup error messages --}}
            <div class="p-3 text-sm text-red-600 bg-red-50 rounded-lg dark:bg-red-950/30 dark:text-red-400"> {{-- Error message container --}}
                @foreach ($errors->all() as $error_msg) {{-- Iterate over error bag items --}}
                    <p>{{ $error_msg }}</p> {{-- Display each error line --}}
                @endforeach {{-- Close error loops --}}
            </div> {{-- Close error container --}}
        @endif {{-- End errors condition --}}
    </div> {{-- Close content wrapper --}}
</div> {{-- Close card element --}}
