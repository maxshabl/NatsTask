<?php

namespace Onex\NatsPackage;

use Illuminate\Support\ServiceProvider;

class NatsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $a = realpath($raw = __DIR__ . '/../config/nats.php');
        $b = config_path('nats.php');
        //$this->publishes([realpath($raw = __DIR__ . '/../config/nats.php') => config_path('nats.php')]);

    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->publishes([realpath($raw = __DIR__ . '/../config/nats.php') => config_path('nats.php')]);
    }
}
