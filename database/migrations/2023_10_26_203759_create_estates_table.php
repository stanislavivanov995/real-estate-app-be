<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('estates', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->string('name');
            $table->text('description');
            $table->smallInteger('rooms');
            $table->integer('price');
            $table->string('currency');
            $table->string('latitude')->nullable();
            $table->string('longtitude')->nullable();
            $table->smallInteger('category_id');
            $table->time('arrive_hour');
            $table->time('leave_hour');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estates');
    }
};
