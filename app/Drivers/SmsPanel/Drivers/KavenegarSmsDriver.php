<?php

namespace App\Drivers\SmsPanel\Drivers;

use App\Drivers\SmsPanel\SmsDriverInterface;
use Kavenegar\Laravel\Facade as Kavenegar;

class KavenegarSmsDriver implements SmsDriverInterface
{
    public function send(string $message, string $to, string $from = null)
    {
        config(
            key: 'kavenegar.apiKey',
            default: config('sms.gateways.kavenegar.api-key')
        );

        try{
            return Kavenegar::Send(
                sender: $from ?: config('sms.gateways.ghasedak.sender'),
                message: $message,
                receptor: [$to]
            );

            // TODO: implement structured result

        }
        catch(\Kavenegar\Exceptions\ApiException $e){
            echo $e->errorMessage();
        }
        catch(\Kavenegar\Exceptions\HttpException $e){
            echo $e->errorMessage();
        }
    }
}
