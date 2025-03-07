<?php

namespace App\Jobs;

use Carbon\Carbon;
use App\Models\Setting;
use App\Models\ChMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class DeleteOldMessagesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */

    public function handle()
    {
        $setting = Setting::first();

        if ($setting && $setting->auto_delete_messages) {
            ChMessage::where('created_at', '<', now()->subDay())->delete();
        }
    }
}
