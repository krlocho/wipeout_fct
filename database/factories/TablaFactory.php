<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Tabla;
use App\Models\User;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tabla>
 */
class TablaFactory extends Factory
{
    protected $model = Tabla::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'Modelo' => $this->faker->word,
            'Marca' => $this->faker->word,
            'Color' => $this->faker->word,
            'User_id' => User::inRandomOrder()->first()->id,
        ];
    }
}
