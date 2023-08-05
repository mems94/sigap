<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'im' => $this->faker->numberBetween(100000, 700000),
            'lastName' => $this->faker->lastName(),
            'firstName' => $this->faker->firstName(),
            'address' => $this->faker->address(),
            'lastDegree' => $this->faker->word(),
            'projectContractFile_path' => $this->faker->filePath()
        ];
    }
}
