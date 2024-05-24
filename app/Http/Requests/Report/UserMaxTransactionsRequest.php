<?php

namespace App\Http\Requests\Report;

use App\DTO\Transaction\TransactionDTO;
use App\Rules\CardNumberRule;
use App\Rules\CashRule;
use App\Rules\TransactionTypeRule;
use Illuminate\Foundation\Http\FormRequest;

class UserMaxTransactionsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
        ];
    }
}
