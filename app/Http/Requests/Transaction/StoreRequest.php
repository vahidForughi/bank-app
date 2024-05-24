<?php

namespace App\Http\Requests\Transaction;

use App\DTO\Transaction\TransactionDTO;
use App\Helpers\GeneralHelpers;
use App\Rules\CardNumberRule;
use App\Rules\CashRule;
use App\Rules\TransactionTypeRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'origin_card_number' => [
                'required',
                'different:destination_card_id',
                new CardNumberRule()
            ],
            'destination_card_number' => [
                'required',
                new CardNumberRule()
            ],
            'cash' => [
                'required',
                new CashRule()
            ],
            'type' => [
                'required',
                new TransactionTypeRule()
            ],
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'origin_card_number' => resolve(GeneralHelpers::class)->normalizeNumbers($this->input('origin_card_number')),
            'destination_card_number' => resolve(GeneralHelpers::class)->normalizeNumbers($this->input('destination_card_number'))
        ]);
    }

}
