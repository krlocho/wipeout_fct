<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Events\ReparacionCreated;
use App\Events\ReparacionUpdated;


class Reparacion extends Model
{
    use HasFactory;
    protected $fillable = [ // Declare mass-assignable attributes list
        'User_id', // Foreign key referencing workshop owner user
        'Tabla_id', // Foreign key referencing surfboard
        'Cliente_id', // Foreign key referencing client owner
        'tracking_code', // Public unique tracking token for external lookup
        'Reparacion', // Description of requested repair work
        'Observaciones', // Workshop notes and extra observations
        'Estado', // Current status (Sin Empezar, En Proceso, Terminado)
        'Precio', // Price charged for the repair
        'Fecha_llegada', // Date surfboard was delivered to workshop
        'Fecha_salida', // Date surfboard was completed or collected
        'foto_url', // File storage path to damage inspection photo
    ]; // Close fillable array definition

    //DEFINIENDO RELACIONES

    public function clientes()
    {
        return $this->belongsTo('App\Models\Cliente', 'Cliente_id', 'id');
    }
    public function tablas()
    {
        return $this->belongsTo('App\Models\Tabla', 'Tabla_id', 'id');
    }

    public function users()
    {
        return $this->belongsTo(User::class);
    }



    //ACCESORES
    public function get_cliente_name()
    {
        if ($this->clientes) { // Verifica si el cliente existe
            return ucwords($this->clientes->Nombre . " " . $this->clientes->Apellido);
        } else {
            // El cliente no existe. Puedes manejar este caso como prefieras.
            // Por ejemplo, podrías devolver una cadena vacía o un mensaje de error:
            return 'Cliente no encontrado';
        }
    }

    public static function getReparacionMayusculas()
    {
        $reparaciones = Reparacion::all()->map(function ($item) {
            $item->Reparacion = ucwords($item->Reparacion);
            $item->get_cliente_name = ucwords($item->get_cliente_name());
            $item->Tabla_id = ucwords($item->Tabla_id);
            $item->Observaciones = ucwords($item->Observaciones);


            // Aquí puedes agregar más columnas que deseas convertir a mayúsculas
            return $item;
        });
        return $reparaciones;
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    //EVENTOS
    public static function generate_tracking_code(): string { // Generate unique short uppercase tracking code
        do { // Loop until an unused random tracking token is found
            $random_chars = strtoupper(substr(bin2hex(random_bytes(4)), 0, 6)); // Create 6 character random hex string
            $candidate_code = 'WP-' . $random_chars; // Prefix token with WP designator
        } while (static::where('tracking_code', $candidate_code)->exists()); // Ensure uniqueness in database table
        return $candidate_code; // Return guaranteed unique tracking code
    } // End of generate_tracking_code method
    protected static function boot() { // Register Eloquent lifecycle model events
        parent::boot(); // Call parent boot implementation
        static::creating(function ($reparacion) { // Hook triggered right before model creation
            if (empty($reparacion->tracking_code)) { // Check if tracking code has not yet been set
                $reparacion->tracking_code = static::generate_tracking_code(); // Auto-assign a unique random tracking code
            } // Close empty tracking code conditional
        }); // Close creating model event listener
        static::created(function ($reparacion) { // Hook triggered after record is saved in database
            event(new ReparacionCreated($reparacion)); // Dispatch custom ReparacionCreated domain event
        }); // Close created event listener
        static::updated(function ($reparacion) { // Hook triggered after record is updated in database
            if ($reparacion->isDirty('Estado') || $reparacion->isDirty('estado')) { // Check if repair status column changed
                event(new ReparacionUpdated($reparacion)); // Dispatch custom ReparacionUpdated domain event
            } // Close status change check
        }); // Close updated event listener
    } // End of boot method
} // End of Reparacion model class
