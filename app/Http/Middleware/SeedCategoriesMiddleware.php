<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

class SeedCategoriesMiddleware
{
    public function handle($request, Closure $next)
    {
        // Check if the categories table is empty
        if (DB::table('categories')->count() === 0) {
            Artisan::call('db:seed', [
                '--class' => 'CategorySeeder', // Replace with your seeder class
            ]);
        }
        return $next($request);
    }
}
