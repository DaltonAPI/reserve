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
        Schema::create('times', function (Blueprint $table) {
            $table->time('monday-start')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->time('monday-end')->nullable();
            $table->time('tuesday-start')->nullable();
            $table->time('tuesday-end')->nullable();
            $table->time('wednesday-start')->nullable();
            $table->time('wednesday-end')->nullable();
            $table->time('thursday-start')->nullable();
            $table->time('thursday-end')->nullable();
            $table->time('friday-start')->nullable();
            $table->time('friday-end')->nullable();
            $table->time('saturday-start')->nullable();
            $table->time('saturday-end')->nullable();
            $table->time('sunday-start')->nullable();
            $table->time('sunday-end')->nullable();
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
        Schema::dropIfExists('times');
    }
};
