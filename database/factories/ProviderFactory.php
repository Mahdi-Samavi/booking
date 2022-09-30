<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Provider>
 */
class ProviderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'firstname' => $this->faker->firstName(),
            'lastname' => $this->faker->lastName(),
            'email' => $this->faker->email(),
            'password' => 'password',
            'phone' => $this->faker->phoneNumber(),
            'biography' => $this->faker->paragraphs(3, true),
            'holiday_work' => $this->faker->boolean(),
            'activities' => json_encode([]),
            'status' => $this->faker->boolean(),
        ];
    }
}
