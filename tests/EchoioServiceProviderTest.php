<?php

namespace Mediumart\Echoio\Tests;

use Mediumart\Echoio\Broadcasting\Broadcasters\RedisBroadcaster;

class EchoioServiceProviderTest extends TestCase
{
    /** @test */
    public function it_extends_redis_broadcaster_creator() 
    {
        $broadcastManager = $this->app->make(\Illuminate\Contracts\Broadcasting\Factory::class);

        $this->assertInstanceOf(RedisBroadcaster::class, $broadcastManager->driver('redis'));
    }
}