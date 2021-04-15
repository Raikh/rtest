<?php

namespace Tests\Mocks\Repositories;

use App\Criterias\CriteriaInterface;
use App\Models\Transaction\UserTransaction;
use App\Models\Transaction\UserTransactionSchedule;
use App\Models\Transaction\UserTransactionStatus;
use App\Models\User;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\TransactionRepositoryInterface;
use App\TO\DTO\DirectTransactionDTO;
use Illuminate\Support\Facades\DB;

class TransactionRepository implements TransactionRepositoryInterface
{
    public function createTransaction(DirectTransactionDTO $transactionDTO) : UserTransaction
    {
        $transaction = new UserTransaction(
            [
                'from_user_id' => $transactionDTO->send_from->getId(),
                'to_user_id' => $transactionDTO->send_to->getId(),
                'amount' => $transactionDTO->amount
            ]
        );

        $transaction->fromUser = $transactionDTO->send_from;
        $transaction->toUser = $transactionDTO->send_to;

        return $transaction;
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

    public function transferFunds(UserTransaction $transaction)
    {
        $amount = $transaction->amount;
        $transaction->fromUser->wallet->balance -= $amount;
        $transaction->toUser->wallet->balance += $amount;

        return $transaction;
    }

    public function switchStatus(UserTransaction $transaction, string $status)
    {
        // TODO: Implement switchStatus() method.
    }

    public function switchScheduleStatus(UserTransactionSchedule $transactionSchedule, string $status)
    {
        // TODO: Implement switchScheduleStatus() method.
    }
}
