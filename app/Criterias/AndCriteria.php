<?php

namespace App\Criterias;

use Illuminate\Database\Eloquent\Builder;

class AndCriteria implements CriteriaInterface
{
    /**
     * @var CriteriaInterface[]
     */
    private $criteriaInterfaces;

    /**
     * AndCriteria constructor.
     *
     * @param CriteriaInterface ...$criteriaInterfaces
     */
    public function __construct(CriteriaInterface ...$criteriaInterfaces)
    {
        $this->criteriaInterfaces = $criteriaInterfaces;
    }

    /**
     * Applies current criteria to given query builder
     *
     * @param Builder $query
     * @return Builder
     */
    public function apply(Builder $query)
    {
        foreach ($this->criteriaInterfaces as $criteriaInterface) {
            $criteriaInterface->apply($query);
        }
        return $query;
    }
}
