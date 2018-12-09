<?php

namespace hamburgscleanest\Instagrammer;

use hamburgscleanest\Instagrammer\Models\Instagrammer;
use Illuminate\Support\ServiceProvider;

/**
 * Class InstagrammerServiceProvider
 * @package hamburgscleanest\Instagrammer
 */
class InstagrammerServiceProvider extends ServiceProvider
{

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot() : void
    {
        $this->publishes([
            __DIR__ . '/config.php' => \config_path('instagrammer.php')
        ]);
    }

    /**
     * Register any package services.
     *
     * @return void
     * @throws \hamburgscleanest\GuzzleAdvancedThrottle\Exceptions\UnknownStorageAdapterException
     * @throws \hamburgscleanest\GuzzleAdvancedThrottle\Exceptions\UnknownCacheStrategyException
     * @throws \Exception
     */
    public function register() : void
    {
        $this->app->singleton('instagrammer', function()
        {
            return new Instagrammer();
        });

        $this->mergeConfigFrom(__DIR__ . '/config.php', 'instagrammer');
    }
}
