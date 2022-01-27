<?php

namespace Tests;

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Laravel\Lumen\Testing\TestCase as BaseTestCase;
use Mockery;
use Mockery\MockInterface;

abstract class TestCase extends BaseTestCase
{
    use DatabaseTransactions, DatabaseMigrations;

    public function createApplication()
    {
        return require __DIR__ . '/../app.php';
    }

    protected function mock(string $abstract): MockInterface
    {
        $mock = Mockery::mock($abstract);

        $this->app->instance($abstract, $mock);

        return $mock;
    }
}
