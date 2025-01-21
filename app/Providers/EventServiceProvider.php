<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Events\ReparacionCreated;
use App\Events\ReparacionUpdated;
use App\Listeners\SendReparacionCreatedEmail;
use App\Listeners\SendReparacionUpdatedEmail;


class EventServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
    protected $listen = [
        ReparacionCreated::class => [
            SendReparacionCreatedEmail::class,
        ],
        ReparacionUpdated::class => [
            SendReparacionUpdatedEmail::class,
        ],
    ];
}
