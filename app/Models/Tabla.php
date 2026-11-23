<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tabla extends Model
{
    use HasFactory;
    public static function getTablaMayusculas()
    {
        $tablas = Tabla::all()->map(function ($item) {
            $item->Color = ucwords($item->Color);
            $item->Marca = ucwords($item->Marca);
            $item->Modelo = ucwords($item->Modelo);
            // Aquí puedes agregar más columnas que deseas convertir a mayúsculas
            return $item;
        });
        return $tablas;
    }

    protected $fillable = [ // List mass-assignable attributes for surfboard model
        'Modelo', // Surfboard model design or shape name
        'Marca', // Surfboard shaper or brand name
        'Color', // Color description or artwork
        'User_id', // Foreign key referencing workshop owner user
        'user_id', // Fallback alias for user id column
    ]; // Close fillable attribute list
    public function user() { // Define relationship to workshop owner user
        return $this->belongsTo(User::class); // Inverse of has-many relationship
    } // End of user relationship method
    public function reparaciones() { // Define relationship to associated repair records
        return $this->hasMany(Reparacion::class, 'Tabla_id', 'id'); // Surfboard has many repairs
    } // End of reparaciones relationship method
} // End of Tabla model class
