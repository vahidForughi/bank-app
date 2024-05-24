<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use App\Http\Requests\Transaction\ShowRequest;
use App\Http\Requests\Transaction\StoreRequest;
use App\Http\Resources\Transaction\TransactionResource;
use App\Services\Transaction\TransactionService;

class TransactionController extends Controller
{

    public function store(StoreRequest $storeRequest)
    {
        $validated_data =  $storeRequest->validated();

        return response()->jsonSuccess(
            data: new TransactionResource(resolve(TransactionService::class)->store(
                originCardNumber: $validated_data['origin_card_number'],
                destinationCardNumber: $validated_data['destination_card_number'],
                cash: $validated_data['cash'],
                type: $validated_data['type'],
            )),
        );
    }

    public function show(ShowRequest $showRequest)
    {
        $validated_data =  $showRequest->validated();

        return response()->jsonSuccess(
            data: new TransactionResource(resolve(TransactionService::class)->fetch(
                id: $validated_data['transaction_id'],
            )),
        );
    }

    public function getReport(GetReportRequest $getReportRequest)
    {
        $validated_data =  $getReportRequest->validated();

        return response()->jsonSuccess(
            data: new TransactionResource(resolve(TransactionService::class)->report()),
        );
    }
}
