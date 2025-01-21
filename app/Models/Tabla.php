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
    public function clientes()
    {
        return $this->hasMany(Tabla::class, 'Tabla_id', 'id');
    }
}
