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
        Commands\TaskReminderCron::class,
        Commands\UpdateTaskUserCron::class,
        Commands\WeeklyTaskOverdueCron::class,
        Commands\EmployeekrataskEntry::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('taskReminder:cron')
                 ->everyFifteenMinutes()
                 ->runInBackground();
                //  ->withoutOverlapping()

        $schedule->command('updateTaskUser:cron')
                ->dailyAt('10:30')
                //->twiceDaily(1, 13);
                ->runInBackground();     
                
        $schedule->command('weeklyTaskOverdue:cron')
                ->weeklyOn(1, '11:00') //On monday
                ->runInBackground();  

        $schedule->command('EmployeekrataskEntry:cron')
                 //->everyMinute()
                 ->dailyAt('00:02')
                 ->runInBackground();              
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
