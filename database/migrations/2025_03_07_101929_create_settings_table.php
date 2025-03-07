<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->boolean('auto_delete_messages')->default(false);
            $table->timestamps();
        });

        // Insert default setting
        DB::table('settings')->insert(['auto_delete_messages' => false]);
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
