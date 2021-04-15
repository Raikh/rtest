<?php

namespace App\Repositories\Interfaces;

use App\Criterias\CriteriaInterface;

interface BaseRepositoryInterface
{
    public function findById($id, $with = [], $withCount = [], $withTrashed = false);
    public function findByCriteria(CriteriaInterface $criteria, $with = [], $withCount = []);
    public function getByCriteria(CriteriaInterface $criteria, $with = [], $withCount = []);
    public function paginateByCriteria(CriteriaInterface $criteria, $with = [], $withCount = [], $perPage = 10);
    public function countByCriteria(CriteriaInterface $criteria);
    public function queryByCriteria(CriteriaInterface $criteria, $with = [], $withCount = []);
    public function count();
    public function all();
}
