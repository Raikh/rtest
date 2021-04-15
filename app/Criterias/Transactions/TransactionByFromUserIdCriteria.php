<?php

namespace App\Criterias\Transactions;

use App\Criterias\CriteriaInterface;
use Illuminate\Database\Eloquent\Builder;

class TransactionByFromUserIdCriteria implements CriteriaInterface
{
    /**
     * @var int
     */
    private $id;

    /**
     * TransactionByFromUserIdCriteria constructor.
     * @param int $id
     */
    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function apply(Builder $query)
    {
        return $query->where('from_user_id', $this->id);
    }
}
