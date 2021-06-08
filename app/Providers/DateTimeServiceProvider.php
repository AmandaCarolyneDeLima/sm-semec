<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class DateTimeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Illuminate\Support\Carbon::macro('toShortDateTime', function () {
            return $this->format('d/m/Y H:i'); /** @phpstan-ignore-line */
        });
        \Illuminate\Support\Carbon::macro('toShortDate', function () {
            return $this->format('d/m/Y'); /** @phpstan-ignore-line */
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
    }
}
