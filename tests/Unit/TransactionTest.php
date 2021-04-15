<?php

namespace Tests\Unit;

use App\Models\Transaction\UserTransaction;
use App\Models\User;
use App\Models\UserWallet;
use App\Repositories\Interfaces\ScheduleTransactionRepositoryInterface;
use App\Repositories\Interfaces\TransactionRepositoryInterface;
use App\Repositories\Interfaces\UsersRepositoryInterface;
use App\Services\Interfaces\TransactionServiceInterface;
use App\TO\DTO\DirectTransactionDTO;
use ReflectionClass;
use Tests\Mocks\Repositories\ScheduleTransactionRepository;
use Tests\Mocks\Repositories\TransactionRepository;
use Tests\Mocks\Repositories\UsersRepository;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    protected array $repositories = [
        UsersRepositoryInterface::class => UsersRepository::class,
        TransactionRepositoryInterface::class => TransactionRepository::class,
        ScheduleTransactionRepositoryInterface::class => ScheduleTransactionRepository::class
    ];
    /**
     * @var TransactionServiceInterface
     */
    protected TransactionServiceInterface $transactionsService;
    /**
     * @var \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|mixed
     */
    private $users;

    public function setUp(): void
    {
        parent::setUp();

        foreach ($this->repositories as $interface => $implementation)
        {
            app()->bind($interface, $implementation);
        }

        $this->generateData();

        $this->transactionsService = app()->make(TransactionServiceInterface::class);
    }

    protected function generateData()
    {
        mt_srand();
        $this->users = User::factory(10)->make([ 'id' => mt_rand(1,500)]);
        $this->users->each(function ($user) {
            $user->wallet = UserWallet::factory()->makeOne([ 'user_id' => $user->id ]);
        });
    }
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $this->assertTrue(true);
    }

    public function testDirectTransaction()
    {
        // Testing protected method
        $reflector = new ReflectionClass( $this->transactionsService );
        $method = $reflector->getMethod( 'directTransaction' );
        $method->setAccessible(true);

        $from = $this->users->first();
        $to = $this->users->last();
        $from_balance = $from->wallet->balance;
        $to_balance = $to->wallet->balance;
        $amount = round($from->wallet->balance/2);
        $transactionDTO = new DirectTransactionDTO();
        $transactionDTO->send_from = $from;
        $transactionDTO->send_to = $to;
        $transactionDTO->amount = $amount;

        $result = $method->invokeArgs($this->transactionsService, array($transactionDTO));

        $this->assertInstanceOf(UserTransaction::class, $result);

        $this->assertEquals($amount, $result->amount);
        $this->assertEquals($from->getId(), $result->from_user_id);
        $this->assertEquals($to->getId(), $result->to_user_id);

        $this->assertEquals($from_balance - $amount, $result->fromUser->wallet->balance);
        $this->assertEquals($to_balance + $amount, $result->toUser->wallet->balance);
    }
}
