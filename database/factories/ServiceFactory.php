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
            'duration' => $this->faker->randomElement(['15m', '30m', '45m', '1h', '1.5h']),
            'presence_type' => $this->faker->randomElement(['in-person', 'zoom', 'google meet']),
            'capacity' => $this->faker->numberBetween(1, 50),
            'cancel_at' => $this->faker->randomElement(['10m', '2h', '1day']),
            'status' => $this->faker->boolean(),
        ];
    }
}
