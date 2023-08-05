<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Avenant>
 */
class AvenantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'avenantNumber' => $this->faker->word(3,true),
            'date' => $this->faker->date(),
            // 'contract_id' => $this->faker->numberBetween(1,700000)
        ];
    }
}
