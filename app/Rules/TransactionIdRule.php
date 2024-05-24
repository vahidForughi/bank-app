<?php

namespace App\Rules;

use App\Models\Transaction;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class TransactionIdRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!is_string($value)) {
            $fail('The :attribute not valid.');
        }
    }
}
