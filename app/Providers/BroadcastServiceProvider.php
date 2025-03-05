<?php

namespace App\Providers;

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Broadcast::routes(['middleware' => ['auth:sanctum']]); // Jetstream utilise Sanctum

        require base_path('routes/channels.php');
    }

//    public function boot(): void
//    {
//        Broadcast::routes();
//
//        require base_path('routes/channels.php');
//    }
}
