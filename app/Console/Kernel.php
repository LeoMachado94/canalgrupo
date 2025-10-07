<?php

namespace App\Console;

use App\Console\Commands\ImportAvatarsClients;
use App\Console\Commands\ImportClients;
use App\Console\Commands\ImportClippings;
use App\Console\Commands\ImportClippingsTwo;
use App\Console\Commands\ImportEditorials;
use App\Console\Commands\ImportFilesClippings;
use App\Console\Commands\ImportSubjectsTwo;
use App\Console\Commands\ImportUsers;
use App\Console\Commands\ImportVehicles;
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
        ImportVehicles::class,
        ImportEditorials::class,
        ImportUsers::class,
        ImportClients::class,
//        ImportClippings::class,
//        ImportSubjectsTwo::class,
        ImportClippingsTwo::class,
        ImportAvatarsClients::class,
        ImportFilesClippings::class
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
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
