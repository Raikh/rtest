<?php

namespace App\Rules;

use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;

class CheckDateRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $date = Carbon::createFromFormat('Y-m-d H', $value, config('user.timezone'))->timezone(config('app.timezone'));
        $now = now();

        return !empty($date) &&
            ($date->format('d') > $now->format('d') ||
            ($date->format('d') === $now->format('d')
                && $date->format('H') > $now->format('H'))
            );
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The hour must be greater than the current one';
    }
}
