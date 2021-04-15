<?php

namespace App\Criterias\Users;

use App\Criterias\CriteriaInterface;
use Illuminate\Database\Eloquent\Builder;

class UserByEmailCriteria implements CriteriaInterface
{
    /**
     * @var string
     */
    private $email;

    /**
     * TransactionByFromUserIdCriteria constructor.
     * @param string $email
     */
    public function __construct(string $email)
    {
        $this->email = $email;
    }

    public function apply(Builder $query)
    {
        return $query->where('users.email', $this->email);
    }
}
