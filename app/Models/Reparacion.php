<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Events\ReparacionCreated;
use App\Events\ReparacionUpdated;


class Reparacion extends Model
{
    use HasFactory;

    protected $fillable = [
        'User_id',
        'Tabla_id',
        'Cliente_id',
        'Reparacion',
        'Observaciones',
        'Estado',
        'Fecha_llegada',
        'Fecha_salida',

        // Agrega aquí cualquier otro atributo que quieras asignar masivamente
    ];

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
    protected static function boot()
    {
        parent::boot();
        //Envio de correo
        static::created(function ($reparacion) {
            event(new ReparacionCreated($reparacion));
        });

        static::updated(function ($reparacion) {
            if ($reparacion->isDirty('estado')) {
                event(new ReparacionUpdated($reparacion));
            };
        });
    }
}
