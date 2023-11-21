<?php

declare(strict_types=1);

namespace App\Providers;

use App\Repositories\Contracts\PetRepositoryInterface;
use App\Repositories\PetRepository;
use Illuminate\Support\ServiceProvider;

class PetServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(PetRepositoryInterface::class, PetRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
