<?php

namespace Domain\Ticket\Requests;

use Domain\Global\Traits\Validation;
use Domain\Ticket\Data\TicketData;
use Illuminate\Foundation\Http\FormRequest;

class TicketRequest extends FormRequest
{
//    use Validation;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {

        return [
            'name' => 'required',
            'problem' => 'required',
            'email' => 'required',
            'mobile' => 'required',
        ];
    }

    public function data(): TicketData
    {
        return new TicketData(
            $this->input('name'),
            $this->input('problem'),
            $this->input('email'),
            $this->input('mobile'),
        );
    }
}
