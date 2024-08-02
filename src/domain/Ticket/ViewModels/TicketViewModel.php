<?php

namespace Domain\Ticket\ViewModels;

use Domain\Ticket\Actions\ListTicketsAction;
use Domain\Ticket\Models\Ticket;
use Domain\Ticket\Resources\TicketResource;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\ViewModels\ViewModel;

class TicketViewModel extends ViewModel
{
    public function __construct(
        public int $perPage,
        public ListTicketsAction $listTicketsAction,
        public ?Ticket $ticket = null
    ) {
    }

    public function tickets(): LengthAwarePaginator
    {
        $params = [
            'limit' => request()->has('limit') ? request()->get('limit') : 20,
            'search' => request()->has('search') ? request()->get('search') : null,
        ];

        return $this->listTicketsAction->execute($params);
    }

    public function ticket(): array|TicketResource
    {
        if ($this->ticket) {
            return TicketResource::make(
                $this->ticket
            );
        }

        return [];
    }
}
