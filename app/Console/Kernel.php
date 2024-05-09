<?php

namespace App\Console;

use App\Console\Commands\Courses\CriteriaCourseCommand;
use App\Console\Commands\Courses\DelayCourseNotNeedStudentCommand;
use App\Console\Commands\MigrateCourseStudentAdded;
use App\Console\Commands\MigrateStudentCSOElon;
use App\Console\Commands\MigrateStudentCSOMoet;
use App\Console\Commands\MigrateStudentData;
use App\Console\Commands\MigrateCsoSub;
use App\Console\Commands\MigrateStudentOnboardingStatus;
use App\Console\Commands\sync_study_performances;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
         $schedule->command('notification:pre-class-notification:send')->everyFiveMinutes();
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

    protected $commands = [
    ];
}
