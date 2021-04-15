<?php

namespace App\Jobs;

use App\Criterias\AndCriteria;
use App\Criterias\Transactions\TransactionByStatusesCriteria;
use App\Models\Transaction\UserTransactionScheduleStatus;
use App\Repositories\Interfaces\ScheduleTransactionRepositoryInterface;
use App\Services\Interfaces\TransactionServiceInterface;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ScheduledTransactionsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct()
    {
        $this->queue = 'schedule_queue';
    }

    public function handle(
        TransactionServiceInterface $transactionsService,
        ScheduleTransactionRepositoryInterface $repository
    )
    {
        $criterias = [
            new TransactionByStatusesCriteria([UserTransactionScheduleStatus::PENDING])
        ];

        $now = Carbon::now();
        $repository->queryByCriteria(new AndCriteria(...$criterias), ['fromUser.wallet'])
            ->chunk(100, function ($scheduledTrxs) use ($transactionsService, $now) {
                foreach ($scheduledTrxs as $scheduledTrx)
                {
                    $wallet = $scheduledTrx->fromUser->wallet;
                    if(!$transactionsService->isWalletLocked($wallet) && $now->greaterThanOrEqualTo($scheduledTrx->schedule_at))
                    {
                        $transactionsService->lockWallet($wallet);
                        $transactionsService->storeJobTransaction($scheduledTrx);
                    }
                }
            });
    }
}
