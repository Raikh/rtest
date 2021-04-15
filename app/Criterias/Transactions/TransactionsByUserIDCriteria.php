<?php


namespace App\Criterias\Transactions;


use App\Criterias\CriteriaInterface;
use Illuminate\Database\Eloquent\Builder;

class TransactionsByUserIDCriteria implements CriteriaInterface
{
    /**
     * @var int
     */
    private $id;

    /**
     * TransactionsByUserIDCriteria constructor.
     * @param int $id
     */
    public function __construct(int $id)
    {

        $this->id = $id;
    }
    public function apply(Builder $query)
    {
        return $query->where(function (Builder $q) {
            return $q->where('from_user_id', $this->id)
                ->orWhere('to_user_id', $this->id);
        });
    }
}
