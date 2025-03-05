<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('messages', function (Blueprint $table) {
            // Add the 'receiver_id' and 'message' columns
            $table->unsignedBigInteger('receiver_id')->after('sender_id');
            $table->text('message')->after('receiver_id');

            // Optionally, add foreign key constraints (if you are using them)
            $table->foreign('receiver_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('messages', function (Blueprint $table) {
            // Drop the columns if rolling back the migration
            $table->dropColumn(['receiver_id', 'message']);
        });
    }
}
