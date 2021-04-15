<?php

namespace App\Providers;

use App\Repositories\Interfaces\ScheduleTransactionRepositoryInterface;
use App\Repositories\Interfaces\TransactionRepositoryInterface;
use App\Repositories\Interfaces\UsersRepositoryInterface;
use App\Repositories\Transactions\ScheduleTransactionRepository;
use App\Repositories\Transactions\TransactionRepository;
use App\Repositories\Users\UsersRepository;
use App\Services\Interfaces\TransactionServiceInterface;
use App\Services\Interfaces\UserServiceInterface;
use App\Services\Transactions\TransactionService;
use App\Services\Users\UserService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    protected array $repositories = [
        UsersRepositoryInterface::class => UsersRepository::class,
        TransactionRepositoryInterface::class => TransactionRepository::class,
        ScheduleTransactionRepositoryInterface::class => ScheduleTransactionRepository::class
    ];

    protected array $services = [
        UserServiceInterface::class => UserService::class,
        TransactionServiceInterface::class => TransactionService::class
    ];

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerInterfaceImplementation($this->repositories);

        $this->registerInterfaceImplementation($this->services);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    protected function registerInterfaceImplementation(array $interfaces)
    {
        foreach ($interfaces as $interface => $implementation)
        {
            $this->app->bind($interface, $implementation);
        }
    }
}
