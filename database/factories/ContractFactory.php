<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contract>
 */
class ContractFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'contractNumber' => $this->faker->numberBetween(10000, 700000),
            'startDate' => $this->faker->date(),
            'endDate' => $this->faker->date(),
            'employee_im' => $this->faker->numberBetween(100000, 700000)
        ];
    }
}
