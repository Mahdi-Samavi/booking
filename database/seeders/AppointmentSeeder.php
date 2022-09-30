<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Provider;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Seeder;

class AppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Appointment::truncate();

        Appointment::factory(5)
            ->state([
                'user_id' => fn () => User::inRandomOrder()->first('id'),
                'provider_id' => fn () => Provider::inRandomOrder()->first('id'),
                'service_id' => fn () => Service::inRandomOrder()->first('id'),
            ])
            ->create();
    }
}
