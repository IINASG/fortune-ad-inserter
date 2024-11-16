<?php

namespace Iinasg\FortuneAdInserter\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Iinasg\FortuneAdInserter\Facades\FortuneAdInserterFacade;
use Iinasg\FortuneAdInserter\FortuneAdInserterServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    public function setUp(): void
    {
        parent::setUp();

    }

    protected function getPackageAliases( $app ): array
    {
        return [
            'FortuneAdInserter' => FortuneAdInserterFacade::class,
        ];
    }

    protected function getPackageProviders($app)
    {
        return [
            FortuneAdInserterServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

    }
}
