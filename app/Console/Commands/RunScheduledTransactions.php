<?php

namespace App\Console\Commands;

use App\Jobs\ScheduledTransactionsJob;
use Illuminate\Console\Command;

class RunScheduledTransactions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run transactions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run scheduled transactions';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        ScheduledTransactionsJob::dispatchNow();
    }
}
