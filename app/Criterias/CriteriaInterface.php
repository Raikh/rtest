<?php


namespace App\Criterias;

use Illuminate\Database\Eloquent\Builder;

interface CriteriaInterface
{
    /**
     * Applies current criteria to given query builder
     *
     * @param Builder $query
     * @return Builder
     */
    public function apply(Builder $query);
}
