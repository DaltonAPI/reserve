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
        Schema::create('listings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('client_id')->nullable();
            $table->unsignedBigInteger('business_id')->nullable();
            $table->string('title');
            $table->string('logo')->nullable();
            $table->string('tags')->nullable();
            $table->string('email')->nullable();
            $table->dateTime('date');
            $table->time('time');
            $table->string('customer_name');
            $table->string('customer_phone')->nullable();
            $table->longText('description')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();

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
        Schema::dropIfExists('listings');
    }
};
