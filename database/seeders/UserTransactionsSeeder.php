<?php


namespace Database\Seeders;

use App\Models\Transaction\UserTransaction;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserTransactionsSeeder extends Seeder
{
    public function run()
    {
        mt_srand();

        for ($i = 0; $i < mt_rand(0, 50); $i++)
        {
            $users = User::orderByRaw('rand()')->limit(2);
            UserTransaction::create(
                [
                    'from_user_id' => $users->first()->id,
                    'to_user_id' => $users->latest()->first()->id,
                    'status_id' => mt_rand(1, 2),
                    'amount' => mt_rand(1, mt_getrandmax())
                ]
            );
        }
    }
}
