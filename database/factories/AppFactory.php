<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\App>
 */
class AppFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $user = random_int(1, 4);

        return [
            'user_id' => $user,
            'app_token' => $user.'|'.Str::random(40),
            'name' => $this->faker->jobTitle(),
        ];
    }
}
