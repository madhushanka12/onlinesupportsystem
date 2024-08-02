<?php

namespace Domain\Ticket\Requests;

use Domain\Ticket\Data\TicketReplyData;
use Illuminate\Foundation\Http\FormRequest;

class TicketReplyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {

        return [
            'reply' => 'required',
        ];
    }

    public function data(): TicketReplyData
    {
        return new TicketReplyData(
            $this->input('reply'),
        );
    }
}
