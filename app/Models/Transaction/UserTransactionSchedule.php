<?php


namespace App\Models\Transaction;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class UserTransactionSchedule extends Model
{
    protected $casts = [
        'schedule_at' => 'datetime',
    ];

    public $guarded = [
        'id'
    ];

    public function fromUser()
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }

    public function toUser()
    {
        return $this->belongsTo(User::class, 'to_user_id');
    }

    public function transaction()
    {
        return $this->belongsTo(UserTransaction::class);
    }

    public function status()
    {
        return $this->belongsTo(UserTransactionScheduleStatus::class);
    }
}
