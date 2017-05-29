<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\WooCommerceSync::class,
        Commands\ExpireOrder::class,
        Commands\PushOrder::class,
        Commands\GenerateSiteMap::class,
        Commands\InitialStockOnProducts::class,
        Commands\UpdateProductInfo::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
         $schedule->command('order:expire')->everyFiveMinutes();
         $schedule->command('woo:sync')->daily();
         $schedule->command('sitemap:generate')->daily();
         $schedule->command('product:stock')->dailyAt('00:30');
    }
    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
