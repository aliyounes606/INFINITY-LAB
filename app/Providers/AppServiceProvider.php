<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Log slow DB queries (> 200 ms) to storage/logs/slow_queries.log
        DB::listen(function ($query) {
            $time = $query->time; // milliseconds
            $threshold = 200; // ms — adjust as needed
            if ($time > $threshold) {
                $sql = $query->sql;
                $bindings = $query->bindings;
                foreach ($bindings as $binding) {
                    $value = is_numeric($binding) ? $binding : "'" . str_replace("'", "\\'", $binding) . "'";
                    $sql = preg_replace('/\?/', $value, $sql, 1);
                }
                $message = '[' . date('Y-m-d H:i:s') . '] ' . $time . " ms | " . $sql . PHP_EOL;
                file_put_contents(storage_path('logs/slow_queries.log'), $message, FILE_APPEND);
            }
        });
    }
}
