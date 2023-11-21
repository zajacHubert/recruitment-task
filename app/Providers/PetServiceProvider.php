<?php

declare(strict_types=1);

namespace App\Providers;

use App\Repositories\Contracts\PetRepositoryInterface;
use App\Repositories\PetRepository;
use App\Services\Contracts\PetServiceInterface;
use App\Services\PetService;
use Illuminate\Support\ServiceProvider;

class PetServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(PetRepositoryInterface::class, PetRepository::class);
        $this->app->bind(PetServiceInterface::class, PetService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
