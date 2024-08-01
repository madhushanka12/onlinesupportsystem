<?php

namespace Domain\User\Rules;

use App\Models\User;
use Illuminate\Contracts\Validation\Rule;

class UserExists implements Rule
{
    public function passes($attribute, $value)
    {
        return User::where('id', $value)->exists();
    }

    public function message(): string
    {
        return 'The selected user does not exist.';
    }
}
