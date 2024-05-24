<?php

namespace App\Drivers\SmsPanel;

use Illuminate\Support\Facades\Log;

class SmsPanel
{
    public SmsDriverInterface $driver;

    public function __construct(SmsDriverInterface $driver)
    {
        $this->setDriver($driver);
    }

    public function setDriver(SmsDriverInterface $driver): void
    {
        $this->driver = $driver;
    }

    public function send(string $message, string $to, string $from = null): void
    {
        Log::info("Sending message to $to :::: $message");

        $this->driver->send(
            message: $message,
            to: $to,
            from: $from,
        );
    }
}
