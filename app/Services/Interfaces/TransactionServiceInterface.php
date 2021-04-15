<?php

namespace App\Services\Interfaces;

use App\Models\Transaction\UserTransactionSchedule;
use App\Models\User;
use App\TO\ValueObjects\TransactionRequestVO;

interface TransactionServiceInterface
{
    public function getUserStatus(User $user);
    public function storeTransaction(TransactionRequestVO $transactionRequest);
    public function storeJobTransaction(UserTransactionSchedule $scheduledTransactions);
    public function paginateTransactionsByUser(User $user, $perPage = 15);
    public function paginateScheduledTransactionsByUser(User $user, $perPage = 15);
}
