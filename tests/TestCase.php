<?php

namespace Mediumart\Echoio\Tests;

use Mediumart\Echoio\EchoioServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class TestCase extends OrchestraTestCase
{
    protected function getPackageProviders($app)
    {
        return [EchoioServiceProvider::class];
    }
}