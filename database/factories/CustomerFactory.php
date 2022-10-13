<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => 'password', // Auto hashing
            'birthday' => $this->faker->date(),
            'phone' => $this->faker->phoneNumber(),
            'country' => $this->faker->country(),
            'state' => $this->faker->citySuffix(),
            'city' => $this->faker->city(),
            'address' => $this->faker->address(),
            'zipcode' => $this->faker->postcode(),
        ];
    }
}
