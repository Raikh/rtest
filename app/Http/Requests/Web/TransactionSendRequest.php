<?php


namespace App\Http\Requests\Web;

use App\Rules\CheckDateRule;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TransactionSendRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'send_from' => [
                'required',
                'email',
                'exists:users,email',
            ],
            'send_to' => [
                'required',
                'email',
                'exists:users,email',
                ],
            'amount' => 'required|numeric|min:0.01',
            'date' => [
                'required',
                new CheckDateRule()
            ]
        ];
    }
}

