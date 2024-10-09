<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Role as ModelsRole;

class ValidRole implements Rule
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
        return in_array($value, array_column(ModelsRole::cases(), 'value'));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The selected role is invalid.';
    }
}