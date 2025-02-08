<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Reparacion;
use App\Models\Cliente;
use App\Models\Tabla;
use App\Models\User;



/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reparacion>
 */
class ReparacionFactory extends Factory
{
    protected $model = Reparacion::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'Reparacion' => $this->faker->word,
            'Fecha_llegada' => $this->faker->date(),
            'Precio' => $this->faker->randomNumber(2),
            'Estado' => $this->faker->randomElement(['Finalizada', 'En proceso', 'Sin empezar']),
            'Cliente_id' => Cliente::inRandomOrder()->first()->id,
            'Tabla_id' => Tabla::inRandomOrder()->first()->id, // Usa un usuario existente
            'User_id' => User::inRandomOrder()->first()->id, // Usa un usuario existente
        ];
    }
}
