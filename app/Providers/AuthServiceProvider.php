<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        'App\Models\App' => 'App\Policies\Api\AppPolicy',
        'App\Models\Customer' => 'App\Policies\Api\CustomerPolicy',
        'App\Models\Service' => 'App\Policies\Api\ServicePolicy',
        'App\Models\Provider' => 'App\Policies\Api\ProviderPolicy',
        'App\Models\Category' => 'App\Policies\Api\CategoryPolicy',
        'App\Models\Appointment' => 'App\Policies\Api\AppointmentPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
