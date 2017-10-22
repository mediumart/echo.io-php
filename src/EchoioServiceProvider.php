<?php

namespace Mediumart\Echoio;

use Illuminate\Support\ServiceProvider;
use Mediumart\Echoio\Broadcasting\Broadcasters\RedisBroadcaster;
use Illuminate\Contracts\Broadcasting\Factory as BroadcastingFactory;

class EchoioServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->make(BroadcastingFactory::class)->extend('redis', function ($app, $config) {
            return new RedisBroadcaster(
                $this->app->make('redis'), [
                    'key' => $this->app['config']['services.broadcasting.key'],
                    'connection' =>  $config['connection'] ?  $config['connection'] : null
                ]
            );
        });
    }
}
