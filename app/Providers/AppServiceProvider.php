<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Policies\EquipmentPolicy;
use App\Policies\EquipmentTypePolicy;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
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
        Gate::policy(Equipment::class, EquipmentPolicy::class);
        Gate::policy(EquipmentType::class, EquipmentTypePolicy::class);
    }
}
