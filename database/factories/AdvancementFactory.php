<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Advancement>
 */
class AdvancementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'contractType' => $this->faker->word(),
            'class' => $this->faker->numberBetween(1,3),
            'echelon' => $this->faker->numberBetween(1,2),
            'indice' => $this->faker->numberBetween(1,2),
            'category' => $this->faker->numberBetween(500, 2000),
            'employee_im' => $this->faker->numberBetween(100000, 700000)
        ];
    }
}
