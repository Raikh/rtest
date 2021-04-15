<?php

namespace App\Criterias;

use Illuminate\Database\Eloquent\Builder;

class EmptyCriteria implements CriteriaInterface
{
    public function apply(Builder $query)
    {
        return $query;
    }
}
