<?php


namespace App\Models\Transaction;

use Illuminate\Database\Eloquent\Model;

class UserTransactionScheduleStatus extends Model
{
    public $timestamps = false;
    protected $guarded = [ 'id' ];

    public const PENDING = 'pending';
    public const SUCCESS = 'success';
    public const FAILED = 'failed';
    public const CANCELED = 'canceled';

    public const statuses = [
        self::PENDING, self::SUCCESS, self::FAILED, self::CANCELED
    ];
}
