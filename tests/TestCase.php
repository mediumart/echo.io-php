<?php

namespace Mediumart\Echoio\Tests;

use Mediumart\Echoio\EchoioServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Mediumart\Echoio\Tests\Fixture\Providers\BroadcastServiceProvider;

class TestCase extends OrchestraTestCase
{
    protected function getPackageProviders($app)
    {
        return [BroadcastServiceProvider::class, EchoioServiceProvider::class];
    }
}

