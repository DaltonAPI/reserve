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
        Schema::table('listings', function (Blueprint $table) {
            // New columns for handling reservations
            $table->unsignedBigInteger('client_id')->nullable();
            $table->unsignedBigInteger('business_id')->nullable();

            // Foreign keys for client and business
            $table->foreign('client_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('business_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('listings', function (Blueprint $table) {
            //
        });
    }
};
