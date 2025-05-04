<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SensorReport>
 */
class SensorReportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tinggi_air' => $this->faker->randomFloat(2, 20, 150),
            'ph' => $this->faker->randomFloat(2, 6.0, 9.0),
            'debit' => $this->faker->randomFloat(2, 5, 50),
            'status' => $this->faker->randomElement(['normal', 'warning', 'critical']),
        ];
    }
}
