<?php

namespace App\Providers;

use App\Models\User; // Asegúrate de importar el modelo
use App\Policies\UserPolicy; // Asegúrate de importar la Policy
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
//use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
/**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // Aquí debes registrar el mapeo:
        User::class => UserPolicy::class,
        // (Si tuvieras otras Policies, como ClientPolicy, irían aquí también)
        // \App\Models\Client::class => \App\Policies\ClientPolicy::class, 
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
