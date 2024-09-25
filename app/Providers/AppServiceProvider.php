<?php

namespace App\Providers;

use App\Domain\Repositories\IDataRepository;
use App\Domain\Repositories\IUserRepository;
use App\Infra\Repositories\DataRepository;
use App\Infra\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(IDataRepository::class, DataRepository::class);
        $this->app->bind(IUserRepository::class, UserRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
