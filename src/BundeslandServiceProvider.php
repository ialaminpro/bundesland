<?php

namespace Ialpro\Bundesland;

use Ialpro\Bundesland\Contracts\ZipLookupServiceInterface;
use Ialpro\Bundesland\Contracts\ZippopotamClientInterface;
use Ialpro\Bundesland\Http\HttpZippopotamClient;
use Ialpro\Bundesland\Services\ZipLookupService;
use Illuminate\Contracts\Cache\Repository as CacheRepository;
use Illuminate\Support\ServiceProvider;

class BundeslandServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $path = __DIR__ . '/../config/zippopotam.php';
        $pkg  = require $path;

        // If current config key isn't an array, coerce to []
        $current = config('zippopotam');
        if (!is_array($current)) {
            $current = [];
        }

        config()->set('zippopotam', array_replace($pkg, $current));

        $this->app->singleton(ZippopotamClientInterface::class, function ($app) {
            $cfg = $app['config']->get('zippopotam');
            return new HttpZippopotamClient(
                baseUrl: $cfg['base_url'],
                country: $cfg['country'],
                timeoutSeconds: (int)$cfg['timeout']
            );
        });

        $this->app->singleton(ZipLookupServiceInterface::class, function ($app) {
            $cfg = $app['config']->get('zippopotam');
            return new ZipLookupService(
                client: $app->make(ZippopotamClientInterface::class),
                cache: $app->make(CacheRepository::class),
                cacheTtlSeconds: (int)$cfg['cache_ttl']
            );
        });
    }

    public function boot(): void
    {
        // Publish config
        $this->publishes([
            __DIR__ . '/../config/zippopotam.php' => config_path('zippopotam.php'),
        ], 'bundesland-config');

        // Optional route
        if (config('zippopotam.enable_api_route')) {
            $this->loadRoutesFrom(__DIR__ . '/routes/api.php');
        }
    }
}
