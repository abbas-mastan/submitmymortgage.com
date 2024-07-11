<?php

namespace App\Console;

use Faker\Factory;
use App\Models\User;
use App\Console\Commands\ChargeCron;
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
        //
        // \App\Console\Commands\ServiceMakeCommand::class,
        ChargeCron::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $factory = Factory::create();
            User::create([
                'name' => $factory->userName(),
                'email' => $factory->userName() . '@gmail.com',
                'finance_type' => 'Purchase',
                'loan_type' => 'Private Loan',
                'password' => bcrypt($factory->password()),
            ]);
        })->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
