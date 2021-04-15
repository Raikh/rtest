<?php


namespace App\Http\Controllers\Web\Users;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\TransactionServiceInterface;
use App\Services\Interfaces\UserServiceInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @var UserServiceInterface
     */
    private UserServiceInterface $usersService;
    /**
     * @var TransactionServiceInterface
     */
    private TransactionServiceInterface $transactionsService;

    /**
     * DashboardController constructor.
     * @param UserServiceInterface $usersService
     * @param TransactionServiceInterface $transactionsService
     */
    public function __construct(
        UserServiceInterface $usersService,
        TransactionServiceInterface $transactionsService
    )
    {
        $this->usersService = $usersService;
        $this->transactionsService = $transactionsService;
    }
    public function show($id)
    {
        $user = $this->usersService->findById($id);

        if(empty($user))
        {
            throw new ModelNotFoundException();
        }

        $transactions = $this->transactionsService->paginateTransactionsByUser($user);
        $scheduledTransactions = $this->transactionsService->paginateScheduledTransactionsByUser($user);
        $stats = $this->transactionsService->getUserStatus($user);

        return view('user.transaction',
            compact('user', 'transactions', 'scheduledTransactions', 'stats')
        );
    }
}
