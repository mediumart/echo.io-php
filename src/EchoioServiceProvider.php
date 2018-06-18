<?php

namespace Mediumart\Echoio;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Illuminate\Broadcasting\BroadcastController;
use Mediumart\Echoio\Http\Middleware\EncodeBroadcastingAuthValidResponse;

class EchoioServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        $this->app->booted(function () {
            $this->broadcastRoutesMiddleware($this->app['router']);
        });
    }

    /**
     * Register a new broadcast routes middleware.
     * 
     * @param  Illuminate\Routing\Router $router      
     */
    protected function broadcastRoutesMiddleware(Router $router)
    {
        $aliasMiddlewareMethod = method_exists($router, 'middleware') ? 
                                                    'middleware' : 'aliasMiddleware';

        $router->{$aliasMiddlewareMethod}(
            'echo.io', EncodeBroadcastingAuthValidResponse::class
        );

        $router->getRoutes()
                ->getByAction(BroadcastController::class.'@authenticate')
                ->middleware('echo.io');
    }
}
