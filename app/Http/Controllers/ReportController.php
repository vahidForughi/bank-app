<?php

namespace App\Http\Controllers;

use App\Http\Requests\Report\UserMaxTransactionsRequest;
use App\Http\Resources\Report\UserMaxTransactionsResource;
use App\Models\Account;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{

    public function userMaxTransaction(UserMaxTransactionsRequest $userTransactionReportRequest)
    {
//        $validated_data =  $userTransactionReportRequest->validated();
//        $time_recent = $validated_data;
//        $user_count = $validated_data;
//        $transactions_count = $validated_data;

        $originsQuery = Transaction::select('*')
                    ->join('cards', 'cards.id', '=', 'transactions.origin_card_id')
                    ->whereNull('transactions.deleted_at')
                    ->whereNull('cards.deleted_at')
                    ->whereNull('accounts.deleted_at')
                    ->join('accounts', 'accounts.id', '=', 'cards.account_id')
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
                        'users.first_name',
                        'users.last_name',
                        'recent_origin.total as recent_origin_total',
                        'recent_destination.total as recent_destination_total',
                        DB::raw('(ifnull(recent_origin.total, 0) + ifnull(recent_destination.total, 0)) as recent_total_transactions'),
                    )
                    ->whereNull('users.deleted_at')
                    ->leftJoinSub(
                        $originsQuery
                            ->where('transactions.created_at', '>', (new \DateTime())->modify('-10 minutes')->format('Y-m-d H:i:s'))
                        , 'recent_origin', function ($join) {
                        $join->on('users.id', '=', 'recent_origin.user_id');
                    })
                    ->leftJoinSub(
                        $destinationsQuery
                            ->where('transactions.created_at', '>', (new \DateTime())->modify('-10 minutes')->format('Y-m-d H:i:s'))
                        , 'recent_destination', function ($join) {
                        $join->on('users.id', '=', 'recent_destination.user_id');
                    })
                    ->groupBy('users.id')
                    ->orderBy('recent_total_transactions', 'desc')
                    ->limit(3)
                    ->rightJoinSub($originsQuery, 'origin', function ($join) {
                        $join->on('users.id', '=', 'origin.user_id')
                            ->orderBy('origin.transaction_created_at', 'desc');
                    })
                    ->rightJoinSub($destinationsQuery, 'destination', function ($join) {
                        $join->on('users.id', '=', 'destination.user_id')
                            ->orderBy('destination.transaction_created_at', 'desc');
                    })
                    ->limit(10)
                    ->groupBy('users.id')
                    ->get();

        // TODO: improve query

        return response()->jsonSuccess(
            data: $maxUsersTransactions
        );
    }
}
