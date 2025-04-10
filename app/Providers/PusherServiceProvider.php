<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\CurlHandler;

class PusherServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Only disable verification in non-production environments and when configured to do so
        if (!env('PUSHER_VERIFY_SSL', true)) {
            // Bind a custom Guzzle client that doesn't verify SSL certificates
            $this->app->bind('GuzzleHttp\Client', function ($app) {
                $handler = new CurlHandler();
                $stack = HandlerStack::create($handler);
                
                return new Client([
                    'handler' => $stack,
                    'verify' => false,
                    'curl' => [
                        CURLOPT_SSL_VERIFYHOST => 0,
                        CURLOPT_SSL_VERIFYPEER => false,
                    ],
                ]);
            });
        }
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
} 