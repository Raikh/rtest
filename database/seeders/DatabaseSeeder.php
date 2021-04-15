<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::transaction(function () {
            \App\Models\User::factory(10, [ 'password' => bcrypt('11111') ])->create();
//          \App\Models\Admin\Admin::factory(1, [ 'password' => bcrypt('11111') ])->create();

            $this->call(WalletSeeder::class);
            $this->call(TransactionStatusesSeeder::class);
            $this->call(TransactionScheduleStatusesSeeder::class);
            $this->call(UserTransactionsSeeder::class);
        });
    }
}
