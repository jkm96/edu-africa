<?php

namespace App\Providers;

use App\Services\Institution\InstitutionService;
use App\Services\Institution\InstitutionServiceInterface;
use App\Services\Location\LocationService;
use App\Services\Location\LocationServiceInterface;
use App\Services\Program\ProgramService;
use App\Services\Program\ProgramServiceInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(InstitutionServiceInterface::class, InstitutionService::class);
        $this->app->bind(LocationServiceInterface::class, LocationService::class);
        $this->app->bind(ProgramServiceInterface::class, ProgramService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
