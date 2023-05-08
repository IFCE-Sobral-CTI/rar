<?php

namespace App\Providers;

use App\Services\Pdf;
use Illuminate\Support\ServiceProvider;

class PdfServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     */
    protected $defer = true;

    /**
     * Register the application services.
     */
    public function register():void
    {
        $this->app->bind(Pdf::class, function ($app) {
            return new Pdf($app['config']['dompdf']);
        });
    }

    /**
     * Get the services provided by the provider.
     */
    public function provides(): array
    {
        return [Pdf::class];
    }
}
