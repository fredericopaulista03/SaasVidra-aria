<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidCnpj implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // Remove non-numeric characters
        $cnpj = preg_replace('/[^0-9]/', '', $value);

        // CNPJ must have 14 digits
        if (strlen($cnpj) != 14) {
            return false;
        }

        // Check for known invalid CNPJs (all same digits)
        if (preg_match('/^(\d)\1{13}$/', $cnpj)) {
            return false;
        }

        // Validate first check digit
        $sum = 0;
        $multipliers = [5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
        for ($i = 0; $i < 12; $i++) {
            $sum += intval($cnpj[$i]) * $multipliers[$i];
        }
        $remainder = $sum % 11;
        $digit1 = ($remainder < 2) ? 0 : 11 - $remainder;

        if (intval($cnpj[12]) != $digit1) {
            return false;
        }

        // Validate second check digit
        $sum = 0;
        $multipliers = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
        for ($i = 0; $i < 13; $i++) {
            $sum += intval($cnpj[$i]) * $multipliers[$i];
        }
        $remainder = $sum % 11;
        $digit2 = ($remainder < 2) ? 0 : 11 - $remainder;

        return intval($cnpj[13]) == $digit2;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'O CNPJ informado não é válido.';
    }
}
