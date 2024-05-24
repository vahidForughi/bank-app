<?php

namespace App\Drivers\SmsPanel\Drivers;

use App\Drivers\SmsPanel\SmsDriverInterface;
use Ghasedak\GhasedakApi;

class GhasedakSmsDriver implements SmsDriverInterface
{
    public function send(string $message, string $to, string $from = null)
    {
        try {
            return (new GhasedakApi(config('sms.gateways.ghasedak.api-key')))
                ->SendSimple(
                    receptor: $to,
                    message: $message,
                    linenumber: $from ?: config('sms.gateways.ghasedak.sender'),
                    senddate: null,
                    checkid: null,
                );

            // TODO: implement structured result

        }
        catch (\Exception $e) {

        }
    }
}
