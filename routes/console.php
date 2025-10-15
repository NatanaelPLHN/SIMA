<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;


Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('app:update-stock-opname-status')->dailyAt('08:59');
// Menjalankan pengecekan stock opname yang sudah lewat deadline
// Schedule::command('app:update-stock-opname-status')->daily();