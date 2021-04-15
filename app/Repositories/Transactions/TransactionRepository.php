<?php

namespace App\Repositories\Transactions;

use App\Models\Transaction\UserTransaction;
use App\Models\Transaction\UserTransactionSchedule;
use App\Models\Transaction\UserTransactionScheduleStatus;
use App\Models\Transaction\UserTransactionStatus;
use App\Models\User;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\TransactionRepositoryInterface;
use App\TO\DTO\DirectTransactionDTO;
use Illuminate\Support\Facades\DB;

class TransactionRepository extends BaseRepository implements TransactionRepositoryInterface
{
    public function __construct(UserTransaction $model)
    {
        parent::__construct($model);
    }

    public function createTransaction(DirectTransactionDTO $transactionDTO) : UserTransaction
    {
        return DB::transaction(function () use ($transactionDTO) {
            $transaction = UserTransaction::create(
                [
                    'from_user_id' => $transactionDTO->send_from->getId(),
                    'to_user_id' => $transactionDTO->send_to->getId(),
                    'amount' => $transactionDTO->amount
                ]
            );
            $transaction->status()
                ->associate(UserTransactionStatus::where('short_name', UserTransactionStatus::PENDING)->first())->save();

            return $transaction;
        });
    }

    public function transferFunds(UserTransaction $transaction)
    {
        return DB::transaction(function () use ($transaction) {
            $from_wallet = $transaction->fromUser->wallet()
                ->lockForUpdate()->first();

            $from_wallet->balance -= $transaction->amount;
            $transaction->toUser->wallet->balance += $transaction->amount;

            $from_wallet->save();
            $transaction->toUser->wallet->save();
            $transaction->status()
                ->associate(UserTransactionStatus::where('short_name', UserTransactionStatus::SUCCESS)->first())->save();

            return $transaction;
        });
    }

    public function switchStatus(UserTransaction $transaction, string $status)
    {
        $status = UserTransactionStatus::where('short_name', $status)->first();
        if(!empty($status))
        {
            return $transaction->status()->associate($status)->save();
        }

        return false;
    }

    public function switchScheduleStatus(UserTransactionSchedule $transactionSchedule, string $status)
    {
        $status = UserTransactionScheduleStatus::where('short_name', $status)->first();
        if(!empty($status))
        {
            return $transactionSchedule->status()->associate($status)->save();
        }

        return false;
    }
}
