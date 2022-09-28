<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $count = 10;

        Category::truncate();

        Category::factory($count)->create();

        Category::factory(10)->state([
            'parent_id' => fn () => random_int(1, $count),
        ])->create();
    }
}
