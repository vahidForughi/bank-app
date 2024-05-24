<?php

namespace App\Services\Transaction;

use App\DTO\Account\AccountUpdateDTO;
use App\DTO\Fee\FeeDTO;
use App\DTO\Transaction\TransactionDTO;
use App\DTO\Transaction\TransactionUpdateDTO;
use App\Events\Transaction\TransactionCreated;
use App\Exceptions\PreConditionFailedException;
use App\Models\Transaction;
use App\Models\User;
use App\Notifications\Transaction\TransactionSucceed;
use App\Repositories\Transaction\TransactionRepositoryInterface;
use App\Services\AccountService\AccountService;
use App\Services\Card\CardService;
use App\Services\Fee\FeeService;
use Illuminate\Contracts\Cache\LockTimeoutException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TransactionService
{
    public function __construct(
        private TransactionRepositoryInterface $transactionRepository,
    ) {}

    public function fetch(
        string $id,
    ): TransactionDTO
    {
        if (empty($transactionDTO = $this->transactionRepository->fetchById($id, [
            'originCard.account.user',
            'destinationCard.account.user',
        ]))) {
            throw new NotFoundHttpException('transaction not found');
        }

        return $transactionDTO;
    }

    public function store(
        string $originCardNumber,
        string $destinationCardNumber,
        string $cash,
        string $type,
    ): TransactionDTO
    {
        if (empty(resolve(CardService::class)->cardNumberExists($originCardNumber))) {
            throw new NotFoundHttpException('origin card not found');
        }

        if (empty(resolve(CardService::class)->cardNumberExists($destinationCardNumber))) {
            throw new NotFoundHttpException('destination card not found');
        }

        if (empty($originCard = resolve(CardService::class)->fetchByCardNumber($originCardNumber))) {
            throw new NotFoundHttpException('origin card not found');
        }

        if (empty($destinationCard = resolve(CardService::class)->fetchByCardNumber($destinationCardNumber))) {
            throw new NotFoundHttpException('destination card not found');
        }

        if ($originCard->id == $destinationCard->id) {
            throw new PreConditionFailedException('destination same to origin');
        }

        if ($originCard->accountID == $destinationCard->accountID) {
            throw new PreConditionFailedException('destination account same to origin account');
        }

        $bankFee = Transaction::getFeeAmount($type);

        if ($originCard->account->cash < bcadd($cash, $bankFee) ) {
            throw new PreConditionFailedException("insufficient funds");
        }

        $transactionDTO = $this->transactionRepository->store(
            new TransactionDTO(
                originCardID: $originCard->id,
                destinationCardID: $destinationCard->id,
                type: $type,
                cash: $cash,
                status: Transaction::STATUS['pending'],
            )
        );

        TransactionCreated::dispatch($transactionDTO->id);

        return $transactionDTO;
    }


    public function transferCash(string $transactionID): void
    {
        $lock = Cache::lock('transaction-transfer-cash', 10);

        $transactionDTO = $this->transactionRepository->fetchByID($transactionID, [
            'originCard.account.user',
            'destinationCard.account.user',
        ]);

        try {

            DB::beginTransaction();

            if ($transactionDTO->status == Transaction::STATUS['pending']){

                $bankFee = Transaction::getFeeAmount($transactionDTO->type);

                if(empty($transactionDTO->originCard)) {
                    throw new \Exception();
                }

                if ($transactionDTO->originCard->account->cash < bcadd($transactionDTO->cash, $bankFee) ) {
                    throw new \Exception('insufficient funds');
                }
                else {

                    resolve(AccountService::class)->update(
                        $transactionDTO->originCard->account->id,
                        new AccountUpdateDTO(
                            cash: bcsub($transactionDTO->originCard->account->cash, bcadd($transactionDTO->cash, $bankFee)),
                        )
                    );

                    if(empty($transactionDTO->destinationCard)) {
                        throw new \Exception();
                    }

                    resolve(AccountService::class)->update(
                        $transactionDTO->destinationCard->account->id,
                        new AccountUpdateDTO(
                            cash: bcadd($transactionDTO->destinationCard->account->cash, $transactionDTO->cash)
                        )
                    );

                    $this->transactionRepository->update(
                        $transactionDTO->id,
                        new TransactionUpdateDTO(
                            status: Transaction::STATUS['success']
                        )
                    );

                    resolve(FeeService::class)->store(
                        new FeeDTO(
                            transactionID: $transactionDTO->id,
                            cash: $bankFee,
                        )
                    );
                }
            }
        }

        catch (\Exception $e) {
            $this->transactionRepository->update(
                $transactionDTO->id,
                new TransactionUpdateDTO(
                    status: Transaction::STATUS['un_success']
                )
            );

            DB::rollBack();
        }
        finally {
            DB::commit();

            $lock?->release();

            $this->sendInfoToOrigin($transactionDTO);

            $this->sendInfoToDestination($transactionDTO);
        }
    }

    public function sendInfoToOrigin(TransactionDTO $transactionDTO)
    {
        $user = new User();

        $user->fill([
            'id' => $transactionDTO->originCard->account->user->id,
            'phone_number' => $transactionDTO->originCard->account->user->phone_number,
        ])->notify(new TransactionSucceed());
    }

    public function sendInfoToDestination(TransactionDTO $transactionDTO)
    {
        $user = new User();

        $user->fill([
            'id' => $transactionDTO->destinationCard->account->user->id,
            'phone_number' => $transactionDTO->destinationCard->account->user->phone_number,
        ])->notify(new TransactionSucceed());
    }

    public function exists(
        string $id,
    ): bool
    {
        return $this->transactionRepository->exists($id);
    }
}
