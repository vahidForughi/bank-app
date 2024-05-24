<?php

namespace App\Drivers\SmsPanel;

interface SmsDriverInterface
{
    public function send(string $message, string $to, string $from = null);
}
