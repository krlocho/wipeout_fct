@props(['completedRepairs', 'inProgressRepairs', 'notStartedRepairs']) {{-- Component properties declaration --}}
<div class="flex flex-col gap-4"> {{-- Status stats module container --}}
    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Estado de las Reparaciones</h3> {{-- Module header --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4"> {{-- Responsive status cards grid --}}
        <a href="{{ route('reparaciones.estado', 'Sin Empezar') }}" class="flex items-center justify-between p-5 bg-white dark:bg-zinc-800 border border-red-200 dark:border-red-900/50 rounded-xl hover:shadow-md transition"> {{-- Pending card --}}
            <div> {{-- Text column --}}
                <span class="text-xs font-semibold text-red-600 dark:text-red-400 uppercase tracking-wider">Sin Empezar</span> {{-- Tag label --}}
                <p class="text-3xl font-extrabold text-gray-900 dark:text-white mt-1">{{ $notStartedRepairs }}</p> {{-- Count value --}}
            </div> {{-- Close text column --}}
            <div class="w-10 h-10 rounded-full bg-red-50 dark:bg-red-950/40 text-red-600 flex items-center justify-center font-bold">!</div> {{-- Icon badge --}}
        </a> {{-- Close pending card --}}
        <a href="{{ route('reparaciones.estado', 'En Proceso') }}" class="flex items-center justify-between p-5 bg-white dark:bg-zinc-800 border border-yellow-200 dark:border-yellow-900/50 rounded-xl hover:shadow-md transition"> {{-- In progress card --}}
            <div> {{-- Text column --}}
                <span class="text-xs font-semibold text-yellow-600 dark:text-yellow-400 uppercase tracking-wider">En Curso</span> {{-- Tag label --}}
                <p class="text-3xl font-extrabold text-gray-900 dark:text-white mt-1">{{ $inProgressRepairs }}</p> {{-- Count value --}}
            </div> {{-- Close text column --}}
            <div class="w-10 h-10 rounded-full bg-yellow-50 dark:bg-yellow-950/40 text-yellow-600 flex items-center justify-center font-bold">⚡</div> {{-- Icon badge --}}
        </a> {{-- Close in progress card --}}
        <a href="{{ route('reparaciones.estado', 'Terminado') }}" class="flex items-center justify-between p-5 bg-white dark:bg-zinc-800 border border-green-200 dark:border-green-900/50 rounded-xl hover:shadow-md transition"> {{-- Completed card --}}
            <div> {{-- Text column --}}
                <span class="text-xs font-semibold text-green-600 dark:text-green-400 uppercase tracking-wider">Terminadas</span> {{-- Tag label --}}
                <p class="text-3xl font-extrabold text-gray-900 dark:text-white mt-1">{{ $completedRepairs }}</p> {{-- Count value --}}
            </div> {{-- Close text column --}}
            <div class="w-10 h-10 rounded-full bg-green-50 dark:bg-green-950/40 text-green-600 flex items-center justify-center font-bold">✓</div> {{-- Icon badge --}}
        </a> {{-- Close completed card --}}
    </div> {{-- Close status grid --}}
</div> {{-- Close container --}}
