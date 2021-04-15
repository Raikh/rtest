<?php

namespace App\TO\DTO;

use App\Models\User;

class DirectTransactionDTO
{
    public User $send_from;
    public User $send_to;
    public int $amount;
}
