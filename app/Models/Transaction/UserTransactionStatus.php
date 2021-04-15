<?php


namespace App\Models\Transaction;

use Illuminate\Database\Eloquent\Model;

class UserTransactionStatus extends Model
{
    public $timestamps = false;
    protected $guarded = [ 'id' ];

    public const SUCCESS = 'success';
    public const FAILED = 'failed';
    public const PENDING = 'pending';
}
