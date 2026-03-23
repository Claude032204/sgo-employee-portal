<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Event;
use App\Listeners\GenerateEmployeePortalId;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Event::listen(
            Verified::class,
            GenerateEmployeePortalId::class,
        );
    }
}