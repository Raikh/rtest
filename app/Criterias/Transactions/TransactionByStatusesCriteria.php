<?php

namespace App\Criterias\Transactions;

use App\Criterias\CriteriaInterface;
use Illuminate\Database\Eloquent\Builder;

class TransactionByStatusesCriteria implements CriteriaInterface
{
    /**
     * @var array
     */
    private $statuses;

    /**
     * TransactionByFromUserIdCriteria constructor.
     * @param array $statuses
     */
    public function __construct(array $statuses)
    {
        $this->statuses = $statuses;
    }

    public function apply(Builder $query)
    {
        return $query->whereHas('status', function (Builder $q) {
            return $q->whereIn('short_name', $this->statuses);
        });
    }
}
