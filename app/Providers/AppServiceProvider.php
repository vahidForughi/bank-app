<?php

namespace App\Providers;

use App\Helpers\GeneralHelpers;
use App\Repositories\Card\CardRepository;
use App\Repositories\Card\CardRepositoryInterface;
use App\Repositories\Transaction\TransactionRepository;
use App\Repositories\Transaction\TransactionRepositoryInterface;
use App\Services\Transaction\TransactionService;
use App\Services\Transaction\TransactionServiceInterface;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->bind(GeneralHelpers::class, GeneralHelpers::class);

        Response::macro('jsonSuccess', function ($data, $status = 200) {
            return Response::json([
                'success' => true,
                'status' => $status,
                'data' => $data,
            ]);
        });

        Response::macro('jsonError', function ($error, $status = 400, $message = null, $trace = null) {
            return Response::json([
                'success' => false,
                'status' => $status,
                'error' => $error,
                'message' => $message,
                'trace' => $trace,
            ]);
        });
    }
}
