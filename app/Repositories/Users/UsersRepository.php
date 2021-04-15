<?php

namespace App\Repositories\Users;

use App\Models\User;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\UsersRepositoryInterface;

class UsersRepository extends BaseRepository implements UsersRepositoryInterface
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function findByEmail($email, $with = [], $withCount = [], $withTrashed = false)
    {
        $query = $this->query($with, $withCount)
            ->where('email', $email);
        if($withTrashed)
        {
            $query->withTrashed();
        }
        return $query->first();
    }}
