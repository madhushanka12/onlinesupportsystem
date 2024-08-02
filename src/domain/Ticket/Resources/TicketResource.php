<?php

namespace Domain\Ticket\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name ?? null,
            'problem' => $this->problem ?? null,
            'email' => $this->email ?? null,
            'mobile' => $this->mobile ?? null,
            'reply' => $this->reply ?? null,
            'status' => $this->status ?? null,
            'referenceNumber' => $this->reference_number ?? null,
        ];
    }
}
