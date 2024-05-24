<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CashRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (strlen($value) > 20) {
            $fail('The :attribute not valid.');
        }

        if ((float)$value < 10000) {
            $fail('The :attribute less than 10000 rial.');
        }

        if ((float)$value > 500000000) {
            $fail('The :attribute grater than 500000000 rial.');
        }
    }
}
