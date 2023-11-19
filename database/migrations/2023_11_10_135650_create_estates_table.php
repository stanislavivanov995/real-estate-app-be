<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('estates', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('price');
            $table->string('currency');
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->smallInteger('category');
            $table->smallInteger('rooms');
            $table->time('arrive_hour');
            $table->time('leave_hour');
            $table->timestamps();
            $table->softDeletes();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('estates');
    }
};
