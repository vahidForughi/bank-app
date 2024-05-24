<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CardNumberRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (empty($value) || strlen($value) !== 16 || !$this->validateCardNumberFormat($value)) {
            $fail('The :attribute not valid.');
        }
    }

    private function validateCardNumberFormat($card_number): bool
    {
        return preg_match("/^[2569]{1}\d{15}$/", $card_number);

        $splited_card_number = str_split($card_number);

        $card_total = 0;

        foreach (str_split($card_number) as $index => $digit) {
            if($index % 2 === 0)
                $card_total += ($digit * 2 > 9) ? ($digit * 2) - 9 : ($digit * 2);
            else
                $card_total += $digit;
        }

        return !($card_total % 10 === 0);
    }
}
