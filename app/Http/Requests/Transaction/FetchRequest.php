<?php

namespace App\Http\Requests\Transaction;

use App\Rules\TransactionIdRule;
use Illuminate\Foundation\Http\FormRequest;

class FetchRequest extends FormRequest
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
            'transaction_id' => [
                'required',
                new TransactionIdRule(),
            ],
        ];
    }

    public function all($keys = null)
    {
        return array_replace_recursive([...$this->input(), 'transaction_id' => $this->route('transaction_id')], $this->allFiles());
    }
}
