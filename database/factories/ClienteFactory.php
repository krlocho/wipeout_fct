<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Cliente;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cliente>
 */
class ClienteFactory extends Factory
{

    protected $model = Cliente::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'Nombre' => $this->faker->name,
            'Apellido' => $this->faker->lastName(),
            'Email' => $this->faker->unique()->safeEmail,
            'Telefono' => $this->faker->phoneNumber,
            'Direccion' => $this->faker->address,

            'User_id' => User::inRandomOrder()->first()->id, // Usa un usuario existente
        ];
    }
}
