<?php


namespace App\Models\Transaction;

use App\Models\User;
use App\Traits\Models\UsesUuid;
use Illuminate\Database\Eloquent\Model;

class UserTransaction extends Model
{
    use UsesUuid;

    public $guarded =[
        'uuid'
    ];

    public function fromUser()
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }

    public function toUser()
    {
        return $this->belongsTo(User::class, 'to_user_id');
    }

    public function status()
    {
        return $this->belongsTo(UserTransactionStatus::class);
    }

    public function schedule()
    {
        return $this->belongsTo(UserTransactionSchedule::class);
    }
}
