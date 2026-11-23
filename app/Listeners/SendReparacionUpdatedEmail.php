<?php // PHP opening tag

namespace App\Listeners; // Namespace declaration for event listeners

use App\Events\ReparacionUpdated; // Import ReparacionUpdated event
use App\Mail\ReparacionUpdatedMail; // Import mail notification class
use App\Models\Cliente; // Import Cliente model
use App\Models\Reparacion; // Import Reparacion model
use Illuminate\Support\Facades\Log; // Import Log facade
use Illuminate\Support\Facades\Mail; // Import Mail facade
use Throwable; // Import Throwable base error interface

class SendReparacionUpdatedEmail { // Listener sending update email notification
    public function handle(ReparacionUpdated $event): void { // Handle event execution
        try { // Wrap mailing in resilient try-catch block
            $reparacion_data = $event->reparacion; // Retrieve repair instance or array from event
            $reparacion_id = is_array($reparacion_data) ? ($reparacion_data['id'] ?? null) : $reparacion_data->id; // Resolve repair primary key
            $reparacion = Reparacion::with('clientes')->find($reparacion_id); // Fetch repair with client relationship
            if (!$reparacion || !$reparacion->clientes || empty($reparacion->clientes->Email)) { // Ensure valid client email exists
                return; // Exit silently if client has no email configured
            } // Close client check
            $cliente = $reparacion->clientes; // Resolve client model instance
            Mail::to($cliente->Email)->send(new ReparacionUpdatedMail($cliente, $reparacion)); // Dispatch email notification to client
        } catch (Throwable $exception) { // Catch any transport or SMTP exception
            Log::warning('No se pudo enviar el correo de actualización de reparación: ' . $exception->getMessage()); // Log warning safely
        } // Close try-catch block
    } // End of handle method
} // End of SendReparacionUpdatedEmail class
