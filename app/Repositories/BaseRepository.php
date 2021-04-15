<?php

namespace App\Repositories;

use App\Criterias\CriteriaInterface;
use App\Repositories\Interfaces\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements BaseRepositoryInterface
{

    protected $model;

    /**
     * BaseRepository constructor.
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @param array $with
     * @param array $withCount
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function query($with = [], $withCount = [])
    {
        return $this->model
            ->query()
            ->with($with)
            ->withCount($withCount);
    }

    /**
     * @param $id
     * @param array $with
     * @param array $withCount
     * @param bool $withTrashed
     * @return Model|null
     */
    public function findById($id, $with = [], $withCount = [], $withTrashed = false)
    {
        $query = $this->query($with, $withCount)
            ->where('id', $id);
        if($withTrashed)
        {
            $query->withTrashed();
        }
        return $query->first();
    }

    /**
     * @param  CriteriaInterface  $criteria
     * @param  array  $with
     * @param  array  $withCount
     * @return Model|null|static
     */
    public function findByCriteria(CriteriaInterface $criteria, $with = [], $withCount = [])
    {
        return $criteria->apply($this->query($with, $withCount))->first();
    }

    /**
     * @param CriteriaInterface $criteria
     * @param array $with
     * @param array $withCount
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getByCriteria(CriteriaInterface $criteria, $with = [], $withCount = [])
    {
        return $criteria->apply($this->query($with, $withCount))->get();
    }

    /**
     * @param CriteriaInterface $criteria
     * @param array $with
     * @param array $withCount
     * @param int $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginateByCriteria(CriteriaInterface $criteria, $with = [], $withCount = [], $perPage = 10)
    {
        return $criteria->apply($this->query($with, $withCount))->paginate($perPage);
    }

    /**
     * @param CriteriaInterface $criteria
     * @return int
     */
    public function countByCriteria(CriteriaInterface $criteria): int
    {
        return $criteria->apply($this->query())->count();
    }

    public function queryByCriteria(CriteriaInterface $criteria, $with = [], $withCount = [])
    {
        return $criteria->apply($this->query($with, $withCount));
    }

    /**
     * @return mixed
     */
    public function count(): mixed
    {
        return $this->model->count();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|Model[]
     */
    public function all(): array|\Illuminate\Database\Eloquent\Collection
    {
        return $this->model::all();
    }
}
