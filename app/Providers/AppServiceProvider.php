<?php

namespace App\Providers;

use App\Models\Event;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        Paginator::defaultView('partials.pagination');

        View::composer('partials.footer', function ($view) {
            $view->with('footerEvents', Event::published()->latest('starts_at')->take(3)->get());
        });
    }
}
