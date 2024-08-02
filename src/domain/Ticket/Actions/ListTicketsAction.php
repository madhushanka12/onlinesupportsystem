<?php

namespace Domain\Ticket\Actions;

use Domain\Ticket\Models\Ticket;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Support\Helper\Helper;

class ListTicketsAction
{
    use Helper;

    public function execute(
        ?array $params = [],
    ): Collection|LengthAwarePaginator
    {

        $search = $params['search'] ?? null;
        $page = $params['page'] ?? null;
        $reference = $params['reference'] ?? null;

        return Ticket::query()
            ->when($search, function (Builder $query) use ($search) {
                return $query->where('name', 'LIKE', "%$search%");
            })
            ->when($reference, function (Builder $query) use ($reference) {
                return $query->where('reference_number', $reference);
            })
            ->latest()
            ->paginate($params['limit'] ?? 20, ['*'], 'page', $page)
            ->withQueryString()
            ->through(function ($ticket) {
                return [
                    'id' => $ticket->id,
                    'name' => $ticket->name ?? null,
                    'problem' => $ticket->problem ?? null,
                    'email' => $ticket->email ?? null,
                    'mobile' => $ticket->mobile ?? null,
                    'reply' => $ticket->reply ?? null,
                    'status' => $ticket->status ?? null,
                    'referenceNumber' => $ticket->reference_number ?? null,
                ];
            });
    }
}
