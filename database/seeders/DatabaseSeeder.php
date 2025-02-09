<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tabla;
use App\Models\Reparacion;
use App\Models\Cliente;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Crear 10 usuarios

        // Crear 10 tablas
        Tabla::factory(10)->create();

        // Crear 20 reparaciones


        // Crear 10 clientes
        Cliente::factory(10)->create();

        Reparacion::factory(20)->create();
    }
}
