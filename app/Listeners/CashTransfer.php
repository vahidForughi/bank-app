<?php

namespace App\Listeners;

use App\Events\Transaction\TransactionCreated;
use App\Services\Transaction\TransactionService;

class CashTransfer
{
    /**
     * Create the event listener.
     */
    public function __construct() {}

    /**
     * Handle the event.
     */
    public function handle(TransactionCreated $event): void
    {

        app(TransactionService::class)->transferCash($event->transactionID);

    }
}
