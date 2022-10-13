<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Appointment>
 */
class AppointmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'amount' => $this->faker->numberBetween(10, 500),
            'duration' => $this->faker->numberBetween(30, 120),
            'start_at' => now()->addDays(random_int(1, 20)),
            'details' => $this->faker->paragraphs(2, true),
        ];
    }
}
