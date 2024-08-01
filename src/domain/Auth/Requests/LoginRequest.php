<?php

namespace Domain\Auth\Requests;

use Domain\Auth\Data\LoginData;
use Domain\Global\Traits\Validation;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    use Validation;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => 'required|string',
            'password' => 'required|string',
        ];
    }

    public function data(): LoginData
    {
        return new LoginData(
            $this->input('email'),
            $this->input('password'),
        );
    }
}