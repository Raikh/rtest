<?php

namespace App\Services\Users;

use App\Criterias\EmptyCriteria;
use App\Repositories\Interfaces\UsersRepositoryInterface;
use App\Services\Interfaces\UserServiceInterface;

class UserService implements UserServiceInterface
{
    /**
     * @var UsersRepositoryInterface
     */
    private UsersRepositoryInterface $userRepository;

    /**
     * UserService constructor.
     * @param UsersRepositoryInterface $userRepository
     */
    public function __construct(
        UsersRepositoryInterface $userRepository
    )
    {
        $this->userRepository = $userRepository;
    }

    public function paginateAllUsers(bool $latestTransaction = false, $perPage = 15)
    {
        return $this->userRepository->paginateByCriteria(
            new EmptyCriteria(),
            $this->queryWith($latestTransaction),
            [],
            $perPage
        );
    }

    public function findById(int $id, $withTrashed = false)
    {
        return $this->userRepository->findById($id, [], [], $withTrashed);
    }

    private function queryWith(bool $latestTransaction = false)
    {
        $with = [
            'wallet'
        ];

        $transactions = $latestTransaction
            ? $with['lastTransactionsFromUser'] =
                function ($q) {
                    return $q->with('toUser');
                }
            : $with['transactionsFromUser'] =
                  function ($q) {
                    return $q->latest()
                        ->with('toUser');
                };


        return $with;
    }
}
