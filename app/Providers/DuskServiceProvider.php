<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Dusk\Browser;
use Facebook\WebDriver\WebDriverBy;

class DuskServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        Browser::macro('selectize', function ($elementId, $value) {
            $this->waitFor("#{$elementId}-selectized");
            $this->click("div.{$elementId} #{$elementId}-selectized");
            $this->click("div.{$elementId} .selectize-dropdown .option[data-value='{$value}']");
            return $this;
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
