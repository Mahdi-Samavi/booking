<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Service>
 */
class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => [config('app.locale') => $this->faker->jobTitle()],
            'amount' => $this->faker->numberBetween(10, 500),
            'description' => $this->faker->paragraphs(3, true),
            'duration' => $this->faker->numberBetween(30, 120),
            'presence_type' => $this->faker->randomElement(['in-person', 'zoom', 'google meet']),
            'capacity' => $this->faker->numberBetween(1, 50),
            'cancel_at' => $this->faker->numberBetween(30, 120),
            'status' => $this->faker->boolean(),
        ];
    }
}
