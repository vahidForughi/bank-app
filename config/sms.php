<?php

use Illuminate\Support\Str;

return [

    /*
    |--------------------------------------------------------------------------
    | Default SmsPanel Gateway Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the sms gateways below you wish
    | to use as your default gateway for all sms work. Of course
    | you may use many gateways at once using the SmsPanel library.
    |
    */

    'default' => env('SMS_GATEWAY', 'ghasedak'),

    /*
    |--------------------------------------------------------------------------
    | SmsPanel Gateways
    |--------------------------------------------------------------------------
    |
    | Here are each of the sms gateways setup for your application.
    | Of course, examples of configuring each gateway panel that is
    | supported by Applicatoin is shown below to make development simple.
    |
    |
    */

    'gateways' => [

        'ghasedak' => [
            'driver' => \App\Drivers\SmsPanel\Drivers\GhasedakSmsDriver::class,
            'api-key' => env('GHASEDAK_SMS_API_KEY'),
            'sender' => env('GHASEDAK_SMS_SENDER_NUMBER'),
        ],

        'kavenegar' => [
            'driver' => \App\Drivers\SmsPanel\Drivers\KavenegarSmsDriver::class,
            'api-key' => env('KAVENEGAR_SMS_API_KEY'),
            'sender' => env('KAVENEGAR_SMS_SENDER_NUMBER'),
        ],

    ],
];
