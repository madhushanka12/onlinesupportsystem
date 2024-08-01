<?php

namespace Domain\Global\Traits;

use Support\Helper\Helper;
use Illuminate\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;

trait Validation
{
    use Helper;

    public function failedValidation(Validator|\Illuminate\Contracts\Validation\Validator $validator): void
    {
        if ($this->requestTypeCheck()) {
            throw new HttpResponseException(response()->json([
                'status'   => false,
                'message'   => 'Validation errors',
                'errors'      => $validator->errors(),
            ], 422));
        }

        throw new ValidationException(
            $validator,
            redirect()
            ->back()
            ->withErrors($validator)
            ->withInput()
        );
    }
}
