<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Role as ModelsRole;

class ValidRole implements Rule
{
    public function passes($attribute, $value)
    {
        return in_array($value, array_column(ModelsRole::cases(), 'value'));
    }

    public function message()
    {
        return 'The selected role is invalid.';
    }
}