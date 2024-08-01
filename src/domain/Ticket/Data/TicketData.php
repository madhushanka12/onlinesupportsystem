<?php

namespace Domain\Ticket\Data;

class TicketData
{
    public function __construct(
        public string $name,
        public ?string $problem,
        public ?string $email,
        public ?string $mobile
    )
    {
    }
}
