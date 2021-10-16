<?php

namespace App\Console;

class Kernel extends \Illuminate\Foundation\Console\Kernel
{
    protected $commands = [];

    protected function schedule(\Illuminate\Console\Scheduling\Schedule $schedule)
    {
    }

    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');
    }
}
