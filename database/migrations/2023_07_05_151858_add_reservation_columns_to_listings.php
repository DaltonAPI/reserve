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
            if (!Schema::hasColumn('listings', 'client_id')) {
                $table->unsignedBigInteger('client_id')->nullable();
                $table->foreign('client_id')->references('id')->on('users')->onDelete('cascade');
            }

            if (!Schema::hasColumn('listings', 'business_id')) {
                $table->unsignedBigInteger('business_id')->nullable();
                $table->foreign('business_id')->references('id')->on('users')->onDelete('cascade');
            }
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
            $table->dropForeign(['client_id']);
            $table->dropForeign(['business_id']);
            $table->dropColumn(['client_id', 'business_id']);
        });
    }
};

