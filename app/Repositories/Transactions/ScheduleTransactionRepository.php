<?php

namespace App\Repositories\Transactions;

use App\Models\Transaction\UserTransactionSchedule;
use App\Models\Transaction\UserTransactionScheduleStatus;
use App\Models\User;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\ScheduleTransactionRepositoryInterface;
use App\TO\ValueObjects\TransactionRequestVO;
use Illuminate\Support\Facades\DB;

class ScheduleTransactionRepository extends BaseRepository implements ScheduleTransactionRepositoryInterface
{
    public function __construct(UserTransactionSchedule $model)
    {
        parent::__construct($model);
    }

    public function createTransaction(TransactionRequestVO $transactionRequest) : UserTransactionSchedule
    {
        return DB::transaction(function () use ($transactionRequest) {
            $transaction = UserTransactionSchedule::create(
                [
                    'from_user_id' => $transactionRequest->getFrom()->getId(),
                    'to_user_id' => $transactionRequest->getTo()->getId(),
                    'amount' => $transactionRequest->getAmount(),
                    'schedule_at' => $transactionRequest->getDate()
                ]
            );
            $transaction->status()
                ->associate(UserTransactionScheduleStatus::where('short_name', UserTransactionScheduleStatus::PENDING)->first())->save();

            return $transaction;
        });
    }
}
