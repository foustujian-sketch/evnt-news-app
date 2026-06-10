<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;


// NewsAPI Cron Job (Runs every hour)
Schedule::command('events:fetch')->hourly();

// Database Cleanup: Automatically delete events older than 3 months
Schedule::command('model:prune', [
    '--model' => [App\Models\EventNews::class],
])->daily();
