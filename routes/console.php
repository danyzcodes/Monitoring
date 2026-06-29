<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Services\TelegramService;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


Schedule::call(function () {
    try {
        (new TelegramService())->sendDailyReport();
        \Log::info('Daily Telegram Report sent successfully.');
    } catch (\Exception $e) {
        \Log::error('Failed to send Daily Telegram Report: ' . $e->getMessage());
    }
})->dailyAt('15:30')->name('telegram:daily-report');
