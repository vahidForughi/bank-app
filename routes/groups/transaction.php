<?php

use App\Http\Controllers\Transaction\TransactionController;


Route::post('/', [TransactionController::class, 'store']);

Route::prefix('/{transaction_id}')->group(function () {

    Route::get('/', [TransactionController::class, 'show']);

});

Route::post('/report', [TransactionController::class, 'getReport']);
