<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if ($this->app->environment('local') && class_exists(\Laravel\Telescope\TelescopeServiceProvider::class)) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // DB::listen(function ($query) {
        //     logger()->info('QUERY EXECUTED', [
        //         'sql' => $query->sql,
        //         'bindings' => $query->bindings,
        //         'time_ms' => $query->time,
        //     ]);
        // });

        // DB::listen(function ($query) {
        //     logger()->info('SQL', [
        //         'sql' => $query->sql,
        //         'trace' => collect(debug_backtrace())
        //             ->take(5)
        //             ->pluck('function')
        //     ]);
        // });
    }
}
