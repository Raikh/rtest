<?php

namespace App\Models;

use App\Models\Transaction\UserTransaction;
use App\Models\Transaction\UserTransactionSchedule;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function wallet()
    {
        return $this->hasOne(UserWallet::class, 'user_id', 'id');
    }

    public function transactionsFromUser()
    {
        return $this->hasMany(UserTransaction::class, 'from_user_id');
    }

    public function lastTransactionsFromUser()
    {
        return $this->hasOne(UserTransaction::class, 'from_user_id')
            ->latest();
    }

    public function transactionsToUser()
    {
        return $this->hasMany(UserTransaction::class, 'to_user_id');
    }

    public function transactions()
    {
        return UserTransaction::query()
            ->where(function ($query) {
                return $query->where('from_user_id', $this->id)
                    ->orWhere('to_user_id', $this->id);
            });
    }

    public function scheduledTransactionsFromUser()
    {
        return $this->hasMany(UserTransactionSchedule::class, 'from_user_id');
    }

    public function scheduledTransactionsToUser()
    {
        return $this->hasMany(UserTransactionSchedule::class, 'to_user_id');
    }

    public function scheduledTransactions()
    {
        return $this->belongsTo(UserTransactionSchedule::class);
    }

    public function getId()
    {
        return $this->id;
    }
}
