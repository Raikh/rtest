<?php

namespace Tests\Mocks\Repositories;

use App\Criterias\CriteriaInterface;
use App\Models\Transaction\UserTransactionSchedule;
use App\Models\Transaction\UserTransactionScheduleStatus;
use App\Models\User;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\ScheduleTransactionRepositoryInterface;
use App\TO\ValueObjects\TransactionRequestVO;
use Illuminate\Support\Facades\DB;

class ScheduleTransactionRepository implements ScheduleTransactionRepositoryInterface
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

    public function findById($id, $with = [], $withCount = [], $withTrashed = false)
    {
        // TODO: Implement findById() method.
    }

    public function findByCriteria(CriteriaInterface $criteria, $with = [], $withCount = [])
    {
        // TODO: Implement findByCriteria() method.
    }

    public function getByCriteria(CriteriaInterface $criteria, $with = [], $withCount = [])
    {
        // TODO: Implement getByCriteria() method.
    }

    public function paginateByCriteria(CriteriaInterface $criteria, $with = [], $withCount = [], $perPage = 10)
    {
        // TODO: Implement paginateByCriteria() method.
    }

    public function countByCriteria(CriteriaInterface $criteria)
    {
        // TODO: Implement countByCriteria() method.
    }

    public function queryByCriteria(CriteriaInterface $criteria, $with = [], $withCount = [])
    {
        // TODO: Implement queryByCriteria() method.
    }

    public function count()
    {
        // TODO: Implement count() method.
    }

    public function all()
    {
        // TODO: Implement all() method.
    }
}
