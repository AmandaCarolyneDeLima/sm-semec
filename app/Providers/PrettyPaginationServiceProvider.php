<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class PrettyPaginationServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        \Illuminate\Pagination\Paginator::currentPageResolver(function ($pageName = 'page') {
            $page = Request()->$pageName;

            if (filter_var($page, FILTER_VALIDATE_INT) !== false && (int) $page >= 1) {
                return (int) $page;
            }

            return 1;
        });
    }
}
