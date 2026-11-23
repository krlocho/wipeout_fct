<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $fillable = [ // List mass-assignable attributes for client model
        'Nombre', // First name of the client
        'Apellido', // Last name of the client
        'Direccion', // Address of the client
        'Telefono', // Phone number of the client
        'Email', // Email address of the client
        'User_id', // Foreign key referencing the owning workshop user
        'user_id', // Fallback alias for user id column
    ]; // Close fillable attribute list

    use HasFactory;
    public static function getClienteMayusculas()
    {
        $clientes = Cliente::all()->map(function ($item) {
            $item->Nombre = ucwords($item->Nombre);
            $item->Apellido = ucwords($item->Apellido);
            $item->Direccion = ucwords($item->Direccion);


            // Aquí puedes agregar más columnas que deseas convertir a mayúsculas
            return $item;
        });
        return $clientes;
    }

    public function reparaciones()
    {
        return $this->hasMany(Reparacion::class, 'Cliente_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function nombreCompleto($value)
    {
        return $this->Nombre . ' ' . $this->Apellido;
    }
}
