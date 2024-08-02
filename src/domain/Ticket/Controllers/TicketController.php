<?php

namespace Domain\Ticket\Controllers;

use App\Http\Controllers\Controller;
use Domain\Ticket\Actions\ListTicketsAction;
use Domain\Ticket\Actions\StoreTicketAction;
use Domain\Ticket\Mails\TicketMail;
use Domain\Ticket\Requests\TicketRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;

class TicketController extends Controller
{

    public function store(
        TicketRequest     $ticketRequest,
        StoreTicketAction $storeTicketAction
    ): JsonResponse
    {
        $ticket = $storeTicketAction->execute(
            $ticketRequest->data()
        );

        Mail::to($ticket->email)->send(new TicketMail($ticket));

        return response()->json([
            'status' => true,
            'type' => 'success',
            'title' => 'Successfully store',
            'reference' => $ticket -> reference_number,
            'message' => __('Ticket Successfully Placed'),
        ]);
    }

    public function fetch(
        ListTicketsAction $listTicketsAction,
    ): JsonResponse
    {
        $params = [
            'reference' => request()->has('reference') ? request()->get('reference') : null,
        ];

        return response()->json([
            'tickets' => $listTicketsAction->execute($params),
        ]);
    }
}
