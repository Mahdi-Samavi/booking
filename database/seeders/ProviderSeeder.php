<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Provider;
use Illuminate\Database\Seeder;

class ProviderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Provider::truncate();

        Provider::factory(5)
            ->afterCreating(function ($provider) {
                $provider->categories()->attach(
                    Category::inRandomOrder()->limit(2)->pluck('id')
                );
            })
            ->create();
    }
}
