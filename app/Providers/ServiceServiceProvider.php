<?php

namespace App\Providers;

use App\Repositories\Account\AccountRepository;
use App\Repositories\Account\AccountRepositoryInterface;
use App\Repositories\Card\CardRepository;
use App\Repositories\Card\CardRepositoryInterface;
use App\Repositories\Fee\FeeRepository;
use App\Repositories\Fee\FeeRepositoryInterface;
use App\Repositories\Transaction\TransactionRepository;
use App\Repositories\Transaction\TransactionRepositoryInterface;
use App\Repositories\User\UserRepository;
use App\Repositories\User\UserRepositoryInterface;
use App\Services\AccountService\AccountService;
use App\Services\Card\CardService;
use App\Services\Transaction\TransactionService;
use App\Services\User\UserService;
use Illuminate\Support\ServiceProvider;

class ServiceServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);

        $this->app->bind(CardRepositoryInterface::class, CardRepository::class);

        $this->app->bind(AccountRepositoryInterface::class, AccountRepository::class);

        $this->app->bind(TransactionRepositoryInterface::class, TransactionRepository::class);

        $this->app->bind(FeeRepositoryInterface::class, FeeRepository::class);

        $this->app->singleton(UserService::class, function ($app) {
            return new UserService(
                $app->make(UserRepositoryInterface::class),
            );
        });

        $this->app->singleton(AccountService::class, function ($app) {
            return new AccountService(
                $app->make(AccountRepositoryInterface::class),
            );
        });

        $this->app->singleton(CardService::class, function ($app) {
            return new CardService(
                $app->make(CardRepositoryInterface::class),
            );
        });

        $this->app->singleton(TransactionService::class, function ($app) {
            return new TransactionService(
                $app->make(TransactionRepositoryInterface::class),
            );
        });

        $this->app->singleton(FeeService::class, function ($app) {
            return new FeeService(
                $app->make(FeeRepositoryInterface::class),
            );
        });

    }
}
