<?php

namespace App\Providers;

use App\Models\ChMessage;
use App\View\Components\SearchResults;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
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
        View::share('notifCount', ChMessage::where('seen', 0)->count());
        Blade::component('search-results', SearchResults::class);
    }
}
