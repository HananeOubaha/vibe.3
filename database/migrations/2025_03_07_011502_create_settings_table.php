<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->boolean('auto_delete_messages')->default(true); // ON by default
            $table->timestamps();
        });

        // Insert default setting
        DB::table('settings')->insert([
            'auto_delete_messages' => true
        ]);
    }
};
