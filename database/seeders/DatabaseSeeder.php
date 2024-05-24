<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Account;
use App\Models\Card;
use App\Models\User;
use Database\Factories\AccountFactory;
use Database\Factories\CardFactory;
use Database\Factories\TransactionFactory;
use Database\Factories\UserFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $newCard = CardFactory::new()->createOne();

        // relational seed
         UserFactory::new()
             ->has(AccountFactory::new()
                     ->has(CardFactory::new()
                         ->has(TransactionFactory::new()
                             ->state(fn (array $attributes, Card $card) => [
                                 'origin_card_id' => $card->id,
                                 'destination_card_id' => $newCard->id,
                             ])
                             ->count(rand(1, 3)), 'withdrawalTransactions')

                         ->has(TransactionFactory::new()
                             ->state(fn (array $attributes, Card $card) => [
                                 'origin_card_id' => $newCard->id,
                                 'destination_card_id' => $card->id,
                             ])
                             ->count(rand(1, 3)), 'depositTransactions')

                         ->state(fn (array $attributes, Account $account) => [
                             'account_id' => $account->id,
                         ])
                         ->count(rand(1, 3)), 'cards')

                 ->state(fn (array $attributes, User $user) => [
                     'user_id' => $user->id,
                 ])
                 ->count(rand(1, 3)), 'accounts')
             ->createMany(3);

        // recursivly seed
        TransactionFactory::new()->createMany(5);
    }
}
