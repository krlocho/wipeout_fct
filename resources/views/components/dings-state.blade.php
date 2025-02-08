<div class="flex flex-col gap-6 repair-status-module">
    <h2>Reparaciones</h2>
    <div class="flex gap-32 repair-status">
        <a href="{{ route('reparaciones.estado', 'Terminado') }}" class="justify-between px-5 py-3 duration-200 border-2 border-green-500 rounded-lg shadow-xl hover:text-white hover:bg-green-900 hover:border-green-900 hover:delay-200 status-item">
            <h3 class="text-lg ">Terminado</h3>
            <p>{{ $completedRepairs }}</p>
        </a>
        <a href="{{ route('reparaciones.estado', 'En Proceso') }}" class="justify-between px-5 py-3 duration-200 border-2 border-gray-400 rounded-lg shadow-xl status-item hover:bg-gray-500 hover:border-gray-500 hover:delay-200">
            <h3 class="text-lg ">En Curso</h3>
            <p>{{ $inProgressRepairs }}</p>
        </a>
        <a href="{{ route('reparaciones.estado', 'Sin Empezar') }}" class="justify-between px-5 py-3 duration-200 border-2 border-red-500 rounded-lg shadow-xl status-item hover:text-white hover:bg-red-900 hover:border-red-900 hover:delay-200">
            <h3 class="text-lg ">Sin Empezar</h3>
            <p>{{ $notStartedRepairs }}</p>
        </a>
    </div>
</div>


</style>
