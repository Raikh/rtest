<?php

namespace App\Repositories\Interfaces;

use App\Models\Transaction\UserTransaction;
use App\Models\Transaction\UserTransactionSchedule;
use App\TO\DTO\DirectTransactionDTO;

interface TransactionRepositoryInterface extends BaseRepositoryInterface
{
    public function createTransaction(DirectTransactionDTO $transactionDTO);
    public function transferFunds(UserTransaction $transaction);
    public function switchStatus(UserTransaction $transaction, string $status);
    public function switchScheduleStatus(UserTransactionSchedule $transactionSchedule, string $status);
}
