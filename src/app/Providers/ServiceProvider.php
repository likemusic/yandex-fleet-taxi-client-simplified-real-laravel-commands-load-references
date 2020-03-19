<?php

namespace Likemusic\Yandex\FleetTaxi\Client\Simplified\Real\Laravel\Commands\Providers;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Likemusic\Yandex\FleetTaxi\Client\Simplified\Real\Laravel\Commands\Console\Commands\UpdateCarReferences as UpdateCarReferencesCommand;
use Likemusic\Yandex\FleetTaxi\Client\Simplified\Real\Laravel\Commands\Console\Commands\UpdateDriverReferences as UpdateDriverReferencesCommand;
use Likemusic\Yandex\FleetTaxi\Client\Simplified\Real\Laravel\Commands\Console\Commands\UpdateAllReferences;

class ServiceProvider extends BaseServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                UpdateCarReferencesCommand::class,
                UpdateDriverReferencesCommand::class,
                UpdateAllReferences::class,
            ]);
        }
    }
}
