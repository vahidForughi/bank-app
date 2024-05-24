<?php

namespace App\Http\Controllers;

use App\Http\Requests\Report\UserMaxTransactionsRequest;
use App\Http\Resources\Report\UserMaxTransactionsResource;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{

    public function userMaxTransaction(UserMaxTransactionsRequest $userTransactionReportRequest)
    {
        $validated_data =  $userTransactionReportRequest->validated();
        $time_recent = $validated_data;
        $user_count = $validated_data;
        $transactions_count = $validated_data;

        $originsQuery = Transaction::select('*')
                    ->whereNull('transactions.deleted_at')
                    ->whereNull('cards.deleted_at')
                    ->whereNull('accounts.deleted_at')
                    ->join('cards', 'cards.id', '=', 'transactions.origin_card_id')
                    ->join('accounts', 'accounts.id', '=', 'cards.account_id')
                    ->whereDate('transactions.created_at', '<=', (new \DateTime())->modify('-10 minutes')->format('Y-m-d H:i:s'))
                    ->select(
                        'transactions.id as transaction_id',
                        'transactions.origin_card_id as transaction_origin_card_id',
                        'transactions.destination_card_id as transaction_destination_card_id',
                        'transactions.cash as transaction_cash',
                        'transactions.type as transaction_type',
                        'transactions.status as transaction_status',
                        'accounts.user_id',
                        DB::raw('count(*) as total')
                    )
                    ->groupBy('accounts.user_id');

        $destinationsQuery = Transaction::select('*')
            ->whereNull('transactions.deleted_at')
            ->whereNull('cards.deleted_at')
            ->whereNull('accounts.deleted_at')
            ->join('cards', 'cards.id', '=', 'transactions.destination_card_id')
            ->join('accounts', 'accounts.id', '=', 'cards.account_id')
            ->whereDate('transactions.created_at', '<=', (new \DateTime())->modify('-10 minutes')->format('Y-m-d H:i:s'))
            ->select(
                'transactions.id as transaction_id',
                'transactions.origin_card_id as transaction_origin_card_id',
                'transactions.destination_card_id as transaction_destination_card_id',
                'transactions.cash as transaction_cash',
                'transactions.type as transaction_type',
                'transactions.status as transaction_status',
                'transactions.created_at as transaction_created_at',
                'transactions.updated_at as transaction_updated_at',
                'transactions.deleted_at as transaction_deleted_at',
                'accounts.user_id',
                DB::raw('count(*) as total')
            )
            ->groupBy('accounts.user_id');

        $maxUsersTransactions = User::select(
                        '*',
                        'users.id',
                        'origin.total as origin_total',
                        'destination.total as destination_total',
                        DB::raw('(ifnull(origin.total, 0) + ifnull(destination.total, 0)) as total_transactions'),
                    )
                    ->whereNull('users.deleted_at')
                    ->leftJoinSub($originsQuery, 'origin', function ($join) {
                        $join->on('users.id', '=', 'origin.user_id');
                    })
                    ->leftJoinSub($destinationsQuery, 'destination', function ($join) {
                        $join->on('users.id', '=', 'destination.user_id');
                    })
//                    ->select('total_transactions', 'users.id', 'users.first_name', 'users.last_name')
                    ->groupBy('users.id')
                    ->orderBy('total_transactions', 'desc')
                    ->limit(3)
                    ->get();

        // TODO: fetch 10 last transactions

        return response()->jsonSuccess(
            data: $maxUsersTransactions
        );
    }
}
