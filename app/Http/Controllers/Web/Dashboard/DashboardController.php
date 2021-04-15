<?php


namespace App\Http\Controllers\Web\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Resources\Users\UserCollection;
use App\Services\Interfaces\UserServiceInterface;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * @var UserServiceInterface
     */
    private UserServiceInterface $usersService;

    /**
     * DashboardController constructor.
     * @param UserServiceInterface $usersService
     */
    public function __construct(
        UserServiceInterface $usersService
    )
    {
        $this->usersService = $usersService;
    }
    public function index(Request $request)
    {
        $users = $this->usersService->paginateAllUsers(true,15);

        //        $users = UserCollection::make($users);
        return view('user.list', compact('users')
        );
    }
}
