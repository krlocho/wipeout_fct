<?php

namespace App\Listeners;

use App\Events\ReparacionCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Mail\ReparacionCreatedMail;
use Illuminate\Support\Facades\Mail;
use App\Models\Cliente;
use App\Models\Reparacion;





class SendReparacionCreatedEmail
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ReparacionCreated $event): void
    {
        $reparacionArray = $event->reparacion; // Obtiene la reparación del evento como un array
        $reparacion = Reparacion::find($reparacionArray['id']); // Convierte el array a un objeto Reparacion
        $cliente = Cliente::find($reparacionArray['Cliente_id']); // Obtiene el objeto Cliente asociado con la reparación
        $mail = new ReparacionCreatedMail($cliente, $reparacion); // Pasa el cliente y la reparación como objeto al constructor

        Mail::to($cliente->Email)->send($mail); // Envía el correo electrónico
    }
}

