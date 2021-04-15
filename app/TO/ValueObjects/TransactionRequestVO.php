<?php


namespace App\TO\ValueObjects;

use App\Models\User;
use App\Repositories\Interfaces\UsersRepositoryInterface;
use Carbon\Carbon;

class TransactionRequestVO
{
    /**
     * @var User
     */
    private User $send_to;
    /**
     * @var User
     */
    private User $send_from;
    /**
     * @var int
     */
    private int $amount;

    /**
     * @var Carbon|null
     */
    private ?Carbon $date;
    /**
     * @var UsersRepositoryInterface
     */
    private UsersRepositoryInterface $userRepository;

    public function __construct(array $data)
    {
        $this->userRepository = app()->make(UsersRepositoryInterface::class);
        $this->parseData($data);
    }

    private function parseData(array $data)
    {
        $this->send_to = $this->userRepository->findByEmail($data['send_to']);
        $this->send_from = $this->userRepository->findByEmail($data['send_from']);
        $this->amount = $data['amount']*100;

        $inputDate = Carbon::createFromFormat('Y-m-d H', $data['date'], config('user.timezone'))
            ->timezone(config('app.timezone'));
        $this->date = !empty($inputDate) ? $inputDate : null;
    }

    public function getFrom(): User
    {
        return $this->send_from;
    }

    public function getTo(): User
    {
        return $this->send_to;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getDate(): ?Carbon
    {
        return $this->date;
    }
}
