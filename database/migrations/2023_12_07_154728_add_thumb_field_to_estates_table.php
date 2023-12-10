<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('estates', function (Blueprint $table) {
            $table->string('thumb')->default('')->after('leave_hour');
        });
    }
    
    public function down(): void
    {
        Schema::table('estates', function (Blueprint $table) {
            $table->dropColumn('thumb');
        });
    }
};
