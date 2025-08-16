<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Socialite\Facades\Socialite;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\CurlHandler;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Konfigurasi Socialite dengan Guzzle verify => false
        Socialite::extend('google', function ($app) {
            $config = $app['config']['services.google'];
            $socialiteConfig = $app['config']['socialite.providers.google'];
            
            $handler = new CurlHandler([
                'curl' => $socialiteConfig['guzzle']['curl']
            ]);
            
            $stack = HandlerStack::create($handler);
            
            $client = new Client([
                'handler' => $stack,
                'verify' => $socialiteConfig['guzzle']['verify'],
                'timeout' => $socialiteConfig['guzzle']['timeout'],
                'connect_timeout' => $socialiteConfig['guzzle']['connect_timeout'],
            ]);
            
            return Socialite::buildProvider(
                \Laravel\Socialite\Two\GoogleProvider::class,
                $config
            )->setHttpClient($client);
        });
    }
}
