<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('currency_rates', function (Blueprint $table) {
            $table->id();
            $table->string('currency');
            $table->decimal('rate');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('currency_rates');
    }
};
