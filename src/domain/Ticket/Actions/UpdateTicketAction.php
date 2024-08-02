<?php

namespace Domain\Ticket\Actions;

use Domain\Ticket\Data\TicketReplyData;
use Domain\Ticket\Models\Ticket;

class UpdateTicketAction
{
    public function execute(
        TicketReplyData $ticketReplyData,
        Ticket $ticket = new Ticket(),
    ): Ticket {
        $ticket->forceFill([
            'reply' => $ticketReplyData->reply,
            'status' => "complete",
        ]);

        $ticket->save();

        $ticket->refresh();

        return $ticket;
    }
}
