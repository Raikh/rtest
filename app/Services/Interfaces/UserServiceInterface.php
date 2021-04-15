<?php

namespace App\Services\Interfaces;

interface UserServiceInterface
{
    public function paginateAllUsers(bool $latestTransaction = false, int $perPage = 15);
    public function findById(int $id, bool $withTrashed = false);
}
