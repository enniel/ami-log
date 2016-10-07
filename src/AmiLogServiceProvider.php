<?php

namespace Enniel\AmiLog;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;

class AmiLogServiceProvider extends ServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $this->app->register(\Enniel\Ami\Providers\AmiServiceProvider::class);
    }

    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../database/migrations/' => database_path('migrations')
        ], 'migrations');

        Event::subscribe(AmiSubscriber::class);
    }
}
