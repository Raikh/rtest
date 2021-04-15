<?php

namespace App\Services\Transactions;

use App\Criterias\AndCriteria;
use App\Criterias\Transactions\TransactionByFromUserIdCriteria;
use App\Criterias\Transactions\TransactionByStatusesCriteria;
use App\Criterias\Transactions\TransactionsByUserIDCriteria;
use App\Models\Transaction\UserTransactionSchedule;
use App\Models\Transaction\UserTransactionScheduleStatus;
use App\Models\Transaction\UserTransactionStatus;
use App\Models\User;
use App\Models\UserWallet;
use App\Repositories\Interfaces\TransactionRepositoryInterface;
use App\Repositories\Interfaces\UsersRepositoryInterface;
use App\Repositories\Transactions\ScheduleTransactionRepository;
use App\Services\Interfaces\TransactionServiceInterface;
use App\TO\DTO\DirectTransactionDTO;
use App\TO\ValueObjects\TransactionRequestVO;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TransactionService implements TransactionServiceInterface
{
    /**
     * @var TransactionRepositoryInterface
     */
    private TransactionRepositoryInterface $transactionRepository;
    /**
     * @var ScheduleTransactionRepository
     */
    private ScheduleTransactionRepository $scheduleTransactionRepository;
    /**
     * @var UsersRepositoryInterface
     */
    private UsersRepositoryInterface $userRepository;

    /**
     * TransactionService constructor.
     * @param TransactionRepositoryInterface $transactionRepository
     * @param ScheduleTransactionRepository $scheduleTransactionRepository
     * @param UsersRepositoryInterface $userRepository
     */
    public function __construct(
        TransactionRepositoryInterface $transactionRepository,
        ScheduleTransactionRepository $scheduleTransactionRepository,
        UsersRepositoryInterface $userRepository
    )
    {

        $this->transactionRepository = $transactionRepository;
        $this->scheduleTransactionRepository = $scheduleTransactionRepository;
        $this->userRepository = $userRepository;
    }

    public function getUserStatus(User $user)
    {
        $criterias = [
            new TransactionByFromUserIdCriteria($user->id),
            new TransactionByStatusesCriteria([UserTransactionScheduleStatus::PENDING])
        ];

        $scheduleQuery = $this->scheduleTransactionRepository->queryByCriteria(new AndCriteria(...$criterias));

        $walletAmount = $user->wallet->balance;
        $blockedAmount = $scheduleQuery->sum('amount');

        return [
            'amount' => $walletAmount,
            'blockedAmount' => $blockedAmount,
            'availableAmount' => $walletAmount - $blockedAmount
        ];
    }

    public function storeTransaction(TransactionRequestVO $transactionRequest): ?UserTransactionSchedule
    {
        $currentUserStats = $this->getUserStatus($transactionRequest->getFrom());

        if($currentUserStats['availableAmount'] < $transactionRequest->getAmount())
        {
            return null;
        }

        return $this->scheduleTransactionRepository->createTransaction($transactionRequest);
    }

    protected function directTransaction(DirectTransactionDTO $transactionDTO)
    {
        $transaction = $this->transactionRepository->createTransaction($transactionDTO);

        try {
            $this->transactionRepository->transferFunds($transaction);
        }
        catch (\Exception $exception)
        {
            $this->transactionRepository->switchStatus($transaction, UserTransactionStatus::FAILED);
            Log::info($exception->getMessage());
        }

        $this->unlockWallet($transaction->fromUser->wallet);
        return $transaction->refresh();
    }

    public function storeJobTransaction(UserTransactionSchedule $scheduledTransactions)
    {
        $transactionDTO = new DirectTransactionDTO();
        $transactionDTO->send_from = $scheduledTransactions->fromUser;
        $transactionDTO->send_to = $scheduledTransactions->toUser;
        $transactionDTO->amount = $scheduledTransactions->amount;

        $fromUserStats = $this->getUserStatus($transactionDTO->send_from);

        if($fromUserStats['availableAmount'] < $transactionDTO->amount)
        {
            return $this->transactionRepository->switchScheduleStatus($scheduledTransactions, UserTransactionScheduleStatus::FAILED);
        }

        DB::beginTransaction();
        try {
            $transaction = $this->directTransaction($transactionDTO);

            $transaction->schedule()->associate($scheduledTransactions)->save();
            $scheduledTransactions->transaction()->associate($transaction)->save();

            if($transaction->status->short_name != UserTransactionStatus::FAILED)
            {
                $result = $this->transactionRepository->switchScheduleStatus($scheduledTransactions, UserTransactionScheduleStatus::SUCCESS);
            }
            else
            {
                $result = $this->transactionRepository->switchScheduleStatus($scheduledTransactions, UserTransactionScheduleStatus::FAILED);
            }

            DB::commit();
        }
        catch (\Throwable $throwable)
        {
            DB::rollBack();
            $result = false;
            Log::info($throwable->getMessage());
        }

        return $result;
    }

    public function paginateTransactionsByUser(User $user, $perPage = 15): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $criterias = [
            new TransactionsByUserIDCriteria($user->id)
        ];

        return $this->transactionRepository->paginateByCriteria(new AndCriteria(...$criterias), [], [], $perPage);
    }

    public function paginateScheduledTransactionsByUser(User $user, $perPage = 15): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $criterias = [
            new TransactionsByUserIDCriteria($user->id)
        ];

        return $this->scheduleTransactionRepository->paginateByCriteria(new AndCriteria(...$criterias), [], [], $perPage);
    }

    public function lockWallet(UserWallet $userWallet): bool
    {
        return Cache::put("wallet_lock_{$userWallet->id}", 1, config('runtime.transactions.wallet.lock_ttl'));
    }

    public function unlockWallet(UserWallet $userWallet): bool
    {
        return Cache::forget("wallet_lock_{$userWallet->id}");
    }

    public function isWalletLocked(UserWallet $userWallet): bool
    {
        return Cache::get("wallet_lock_{$userWallet->id}") == 1;
    }
}
