<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Menu>
 */
class MenuFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "nom" => $this->faker->unique()->word(),
            "description" => $this->faker->words(10, true),
            "prix" => $this->faker->randomFloat(2, 0, 20),
            "estVege" => $this->faker->boolean(70),
            /* "image" => $this->$faker->image(storage_path('images'), 50, 50) */
        ];
    }
}
