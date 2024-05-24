<?php

namespace App\Listeners;

use App\Drivers\SmsPanel\SmsPanel;
use App\Events\Transaction\TransactionDone;
use App\Services\Transaction\TransactionService;

class SmsTransactionInfoToOrigin
{
    /**
     * Create the event listener.
     */
    public function __construct() {}

    /**
     * Handle the event.
     */
    public function handle(TransactionDone $event): void
    {
        $transactionDTO = app(TransactionService::class)->sendInfo($event->transactionID);
        $transactionDTO = app(TransactionService::class)->fetch($event->transactionID);

        SmsPanel::send(
            message: 'Transaction',
            to: $transactionDTO->originCard->account->user->phone_number
        );

    }
}
