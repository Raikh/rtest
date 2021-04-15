<?php

namespace App\Repositories\Interfaces;

interface UsersRepositoryInterface extends BaseRepositoryInterface
{
    public function findByEmail($email, $with = [], $withCount = [], $withTrashed = false);
}
