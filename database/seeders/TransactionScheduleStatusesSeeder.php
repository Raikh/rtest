<?php


namespace Database\Seeders;

use App\Models\Transaction\UserTransactionScheduleStatus;
use Illuminate\Database\Seeder;

class TransactionScheduleStatusesSeeder extends Seeder
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

        [
            'id' => 4,
            'short_name' => 'canceled',
            'title' => 'Отменено'
        ],
    ];

    public function run()
    {
        foreach ($this->statuses as $status)
        {
            UserTransactionScheduleStatus::updateOrCreate(
                [
                    'id' => $status['id'],
                    'short_name' => $status['short_name']
                ],

                $status
            );
        }
    }
}
