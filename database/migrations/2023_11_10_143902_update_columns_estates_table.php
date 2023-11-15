<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('estates', function (Blueprint $table) {
            $table->string('arrive_hour')->change();
            $table->string('leave_hour')->change();
        });
    }

    public function down(): void
    {
        Schema::table('estates', function (Blueprint $table) {
            $table->time('arrive_hour')->change();
            $table->time('leave_hour')->change();
        });
    }
};
