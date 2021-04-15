<?php

namespace Database\Factories;

use App\Models\UserWallet;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserWalletFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UserWallet::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        mt_srand();
        return [
            'user_id' => mt_rand(1, 500),
            'balance' => mt_rand(500, mt_getrandmax())
        ];
    }
}
