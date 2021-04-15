<?php

namespace App\Repositories\Interfaces;

use App\Models\User;
use App\TO\ValueObjects\TransactionRequestVO;

interface ScheduleTransactionRepositoryInterface extends BaseRepositoryInterface
{
    public function createTransaction(TransactionRequestVO $transactionRequest);
}
