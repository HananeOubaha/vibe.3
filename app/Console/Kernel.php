<?php

namespace App\Console;

use App\Jobs\DeleteOldMessagesJob;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule)
    {
        // Check if the setting for auto-delete is enabled
        $schedule->call(function () {
            $setting = \App\Models\Setting::first();

            if ($setting && $setting->auto_delete_messages) {
                // If the setting is enabled, dispatch the job
                DeleteOldMessagesJob::dispatch();
            }
        })->everyMinute();  // Adjust frequency (e.g., every minute)
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
