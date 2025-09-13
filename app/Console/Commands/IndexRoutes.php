<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class IndexRoutes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'routes:index';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Fetch all routes
        $routes = Route::getRoutes();

        // Clear existing data in the table
        DB::table('routes_index')->truncate();

        // Insert only GET routes and those without parameters into the database
        foreach ($routes as $route) {
            if ($route->methods()[0] === 'GET' && !$this->hasParameters($route)) {
                DB::table('routes_index')->insert([
                    'uri' => $route->uri(),
                    'name' => $route->getName(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        $this->info('Routes have been indexed successfully.');
    }

    /**
     * Check if the route has parameters.
     *
     * @param  \Illuminate\Routing\Route  $route
     * @return bool
     */
    protected function hasParameters($route)
    {
        // Check if the route URI contains parameters (e.g., {id})
        return strpos($route->uri(), '{') !== false;
    }
}
