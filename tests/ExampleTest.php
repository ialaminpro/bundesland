<?php

namespace Ialpro\Bundesland\Tests;

use Orchestra\Testbench\TestCase;
use Ialpro\Bundesland\BundeslandServiceProvider;
use Ialpro\Bundesland\Facades\ZipLookup;

class ExampleTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [BundeslandServiceProvider::class];
    }

    protected function getPackageAliases($app)
    {
        return ['ZipLookup' => ZipLookup::class];
    }

    public function test_facade_exists()
    {
        $this->assertTrue(class_exists(ZipLookup::class));
    }
}
