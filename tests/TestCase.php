<?php

namespace Ubuntu\Press\Tests;

use Ubuntu\Press\PressBaseServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->withFactories(__DIR__.'/../database/factories');

    }

    /**
     * Get package providers.
     * 
     * @param \Illuminate\Foundation\Application  $app
     * 
     * @return array
     */

    protected function getPackageProviders($app)
    {
        return [
            PressBaseServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetup($app)
    {
        $app['config']->set('database.default', 'testdb');
        $app['config']->set('database.connections.testdb', [
            'driver' => 'sqlite',
            'database' => ':memory:'
        ]);
    }
}