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
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
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
    }
}
