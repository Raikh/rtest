<?php

namespace Tests\Mocks\Repositories;

use App\Criterias\CriteriaInterface;
use App\Models\User;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\UsersRepositoryInterface;

class UsersRepository implements UsersRepositoryInterface
{
    public function findByEmail($email, $with = [], $withCount = [], $withTrashed = false)
    {

    }

    public function findById($id, $with = [], $withCount = [], $withTrashed = false)
    {
        // TODO: Implement findById() method.
    }

    public function findByCriteria(CriteriaInterface $criteria, $with = [], $withCount = [])
    {
        // TODO: Implement findByCriteria() method.
    }

    public function getByCriteria(CriteriaInterface $criteria, $with = [], $withCount = [])
    {
        // TODO: Implement getByCriteria() method.
    }

    public function paginateByCriteria(CriteriaInterface $criteria, $with = [], $withCount = [], $perPage = 10)
    {
        // TODO: Implement paginateByCriteria() method.
    }

    public function countByCriteria(CriteriaInterface $criteria)
    {
        // TODO: Implement countByCriteria() method.
    }

    public function queryByCriteria(CriteriaInterface $criteria, $with = [], $withCount = [])
    {
        // TODO: Implement queryByCriteria() method.
    }

    public function count()
    {
        // TODO: Implement count() method.
    }

    public function all()
    {
        // TODO: Implement all() method.
    }
}
