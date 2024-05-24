<?php

namespace App\Providers;

use App\Drivers\SmsPanel\Drivers\GhasedakSmsDriver;
use App\Drivers\SmsPanel\SmsDriverInterface;
use App\Drivers\SmsPanel\SmsPanel;
use Illuminate\Support\ServiceProvider;

class DriverServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        app()->bind(SmsDriverInterface::class, config('sms.gateways.' . config('sms.default') . '.driver'));

        app()->singleton(SmsPanel::class, function ($app) {
            return new SmsPanel($app->make(SmsDriverInterface::class));
        });
    }
}
