<div class=" repair-status-module">
    <h2>Reparaciones</h2>
    <div class="flex gap-6 repair-status">
        <div class="bg-gray-400 border-2 border-gray-300 rounded-lg status-item">
            <h3>Reparaciones Finalizadas</h3>
            <p>{{ $completedRepairs }}</p>
        </div>
        <div class="status-item">
            <h3>Reparaciones en Curso</h3>
            <p>{{ $inProgressRepairs }}</p>
        </div>
        <div class="status-item">
            <h3>Reparaciones sin Empezar</h3>
            <p>{{ $notStartedRepairs }}</p>
        </div>
    </div>
</div>


</style>
