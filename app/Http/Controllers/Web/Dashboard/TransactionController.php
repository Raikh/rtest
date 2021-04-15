<?php


namespace App\Http\Controllers\Web\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\TransactionSendRequest;
use App\Services\Interfaces\TransactionServiceInterface;
use App\TO\ValueObjects\TransactionRequestVO;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * @var TransactionServiceInterface
     */
    private TransactionServiceInterface $transactionsService;

    /**
     * TransactionController constructor.
     * @param TransactionServiceInterface $transactionsService
     */
    public function __construct(
        TransactionServiceInterface $transactionsService
    )
    {
        $this->transactionsService = $transactionsService;
    }

    public function send(TransactionSendRequest $request)
    {
        $transactionRequest = new TransactionRequestVO($request->validated());
        $transaction = $this->transactionsService->storeTransaction($transactionRequest);

        if(empty($transaction))
        {
            return back()->with('failed', 'Not enough money');
        }

        return back()->with('success', 'Transaction scheduled');
    }
}
