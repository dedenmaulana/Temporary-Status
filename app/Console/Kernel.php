<?php

namespace App\Console;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Status;
use App\Jobs\DeleteStatus;
use App\Jobs\PostStatus;

class Kernel extends ConsoleKernel
{
    use DispatchesJobs;
    
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [

    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //post
        $schedule->call(function () {
            $statuses = Status::readyToPost()->get();
            foreach ($statuses as $status) {
                $this->dispatch(new PostStatus($status));
            }
        })->everyMinute();

        //delete
        $schedule->call(function () {
            $statuses = Status::readyToDelete()->get();
            foreach ($statuses as $status) {
                $this->dispatch(new DeleteStatus($status));
            }
        })->everyMinute();
    }
}
