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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique()->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('bio')->nullable();
            $table->string('contact_info');
            $table->json('social_media')->nullable();
            $table->string('Facebook_links')->nullable();
            $table->string('Instagram_links')->nullable();
            $table->string('Twitter_links')->nullable();
            $table->string('industry_category')->nullable();;
            $table->string('photos')->nullable();
            $table->string('account_type')->nullable();
            $table->string('client-name')->nullable();
            $table->string('serviceList')->nullable();
            $table->string('location')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
