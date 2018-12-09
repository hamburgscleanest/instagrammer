<?php

namespace hamburgscleanest\Instagrammer\Tests;

use hamburgscleanest\Instagrammer\InstagrammerServiceProvider;
use Illuminate\Support\Facades\Config;
use Orchestra\Testbench\TestCase as Orchestra;

/**
 * Class TestCase
 * @package hamburgscleanest\Instagrammer\Tests
 */
class TestCase extends Orchestra
{

    public function setUp() : void
    {
        parent::setUp();
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageProviders($app) : array
    {
        return [InstagrammerServiceProvider::class];
    }
}
