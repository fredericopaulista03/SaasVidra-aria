<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidCpfOrCnpj implements Rule
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
        $document = preg_replace('/[^0-9]/', '', $value);

        // Check if it's CPF (11 digits) or CNPJ (14 digits)
        if (strlen($document) == 11) {
            $cpfValidator = new ValidCpf();
            return $cpfValidator->passes($attribute, $value);
        } elseif (strlen($document) == 14) {
            $cnpjValidator = new ValidCnpj();
            return $cnpjValidator->passes($attribute, $value);
        }

        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'O CPF ou CNPJ informado não é válido.';
    }
}
