<?php

namespace Domain\Ticket\Actions;

use Domain\Ticket\Models\Ticket;
use Illuminate\Database\Eloquent\Builder;

class GenerateReferenceNumberAction
{
    public function execute(): string
    {
        return $this->nextReferenceNumber();
    }

    protected function nextReferenceNumber(): string
    {
        if ($this->ticketDoesntHaveReferenceNumber()) {
            return '00001';
        }

        $lastReferenceNumber = $this->getLastReferenceNumber();
        $nextReferenceNumber = (int) $lastReferenceNumber + 1;

        return str_pad((string)$nextReferenceNumber, 5, '0', STR_PAD_LEFT);
    }

    protected function ticketDoesntHaveReferenceNumber(): bool
    {
        return $this->ticket()->doesntExist();
    }

    protected function ticket(): Builder
    {
        return Ticket::withTrashed()->whereNotNull('reference_number');
    }

    protected function getLastReferenceNumber(): string
    {
        $lastTicket = $this->ticket()->latest('created_at')->first();

        if (!$lastTicket) {
            return '00000';
        }

        return $lastTicket->reference_number;
    }
}
