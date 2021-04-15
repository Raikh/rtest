<?php


namespace Database\Seeders;

use App\Models\Transaction\UserTransactionStatus;
use Illuminate\Database\Seeder;

class TransactionStatusesSeeder extends Seeder
{
    protected $statuses = [
        [
            'id' => 1,
            'short_name' => 'pending',
            'title' => 'Запланировано'
        ],

        [
            'id' => 2,
            'short_name' => 'success',
            'title' => 'Успешно'
        ],

        [
            'id' => 3,
            'short_name' => 'failed',
            'title' => 'Не успешно'
        ],
    ];

    public function run()
    {
        foreach ($this->statuses as $status)
        {
            UserTransactionStatus::updateOrCreate(
                [
                    'id' => $status['id'],
                    'short_name' => $status['short_name']
                ],

                $status
            );
        }
    }
}
