<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Service::truncate();

        Service::factory(5)
            ->afterCreating(function ($service) {
                $service->categories()->attach(
                    Category::inRandomOrder()->limit(2)->pluck('id')
                );
            })
            ->create();
    }
}
