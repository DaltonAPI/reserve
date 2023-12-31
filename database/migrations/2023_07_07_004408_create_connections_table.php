<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('connections', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(); // The ID of the user sending the connection request
            $table->unsignedBigInteger('connected_user_id')->nullable(); // The ID of the user receiving the connection request
            $table->boolean('accepted')->default(false)->nullable(); // Indicates whether the connection request has been accepted
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('connections', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['connected_user_id']);
            $table->dropColumn(['user_id', 'connected_user_id']);
        });
    }

};
