<?php


namespace Database\Seeders;


use App\Models\User;
use App\Models\UserWallet;
use Illuminate\Database\Seeder;

class WalletSeeder extends Seeder
{
    public function run()
    {
        mt_srand();
        User::all()
            ->each(function ($user) {
                UserWallet::create([
                    'user_id' => $user->id,
                    'balance' => mt_rand(500, mt_getrandmax()) / 100
                ]);
            });
    }
}
