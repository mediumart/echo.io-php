<?php

namespace Mediumart\Echoio\Tests;

use Illuminate\Support\Arr;
use Illuminate\Broadcasting\BroadcastController;

class EchoioServiceProviderTest extends TestCase
{
    /** @test */
    public function it_register_broadcasting_auth_route_middleware() 
    {
        $router = $this->app['router'];
        $this->assertTrue(Arr::has($router->getMiddleware(), 'echo.io'));
        
        $route =  $router->getRoutes()->getByAction(BroadcastController::class.'@authenticate');
        $this->assertTrue(!! array_search('echo.io', $route->middleware()));
    }
}