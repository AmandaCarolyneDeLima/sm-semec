<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\User;
use App\Observers\UserObserver;
use App\Models\Servant;
use App\Observers\ServantObserver;
use App\Models\Pdf;
use App\Observers\PdfObserver;
use App\Models\Edict;
use App\Observers\EdictObserver;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(\Faker\Generator::class, function () {
            return \Faker\Factory::create('pt_BR');
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        User::observe(UserObserver::class);
        Servant::observe(ServantObserver::class);
        Pdf::observe(PdfObserver::class);
        Edict::observe(EdictObserver::class);
        Paginator::useBootstrap();
    }
}
