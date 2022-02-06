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
        Commands\UpdateSubscriptionCron::class,
        // Commands\ValidateAndroidSubscription::class,
        // Commands\ValidateIosSubscription::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('updatesubscription')->daily();
			$schedule->command('updatesubscription')->cron('* 10 * * *');
            $schedule->command('updatesubscription')->cron('* 12 * * *');
            $schedule->command('android-subscription:validate')->everyFiveMinutes();
            $schedule->command('ios-subscription:validate')->everyFiveMinutes();
    
            

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
