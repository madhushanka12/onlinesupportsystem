<?php

namespace Domain\Ticket\Actions;

use Domain\Ticket\Data\TicketData;
use Domain\Ticket\Models\Ticket;

class StoreTicketAction
{
    public function execute(
        TicketData $ticketData,
        Ticket $ticket = new Ticket(),
    ): Ticket {
        $ticket->forceFill([
            'reference_number' =>  (new GenerateReferenceNumberAction())->execute(),
            'name' => $ticketData->name,
            'problem' => $ticketData->problem,
            'email' => $ticketData->email,
            'mobile' => $ticketData->mobile,
        ]);

        $ticket->save();

        $ticket->refresh();

        return $ticket;
    }
}
