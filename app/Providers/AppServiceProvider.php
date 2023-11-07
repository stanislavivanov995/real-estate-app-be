<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }
    
    public function boot(): void
    {
        if (DB::table('categories')->count() === 0) {
            Artisan::call('db:seed', [
                '--class' => 'CategorySeeder',
            ]);
        }
    }
}
