<?php

namespace Domain\Ticket\Controllers\Admin;

use App\Http\Controllers\Controller;
use Domain\Ticket\Actions\ListTicketsAction;
use Domain\Ticket\Actions\StoreTicketAction;
use Domain\Ticket\Actions\UpdateTicketAction;
use Domain\Ticket\Mails\TicketMail;
use Domain\Ticket\Mails\TicketReplyMail;
use Domain\Ticket\Models\Ticket;
use Domain\Ticket\Requests\TicketReplyRequest;
use Domain\Ticket\Requests\TicketRequest;
use Domain\Ticket\ViewModels\TicketViewModel;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class TicketController extends Controller
{
    public const INDEX_ROUTE = 'tickets.index';

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(
        ListTicketsAction $listTicketsAction
    ): InertiaResponse {
        $viewModel = new TicketViewModel(
            20,
            $listTicketsAction
        );

        return Inertia::render('Tickets/Index', $viewModel);
    }

    public function show(
        Ticket $ticket,
        ListTicketsAction $listTicketsAction
    ): InertiaResponse {
        $viewModel = new TicketViewModel(
            20,
            $listTicketsAction,
            $ticket
        );

        return Inertia::render('Tickets/Index', $viewModel);
    }

    public function update(
        Ticket $ticket,
        TicketReplyRequest $replyRequest,
        UpdateTicketAction $updateTicketAction
    ) {

            $ticketUpdate = $updateTicketAction->execute(
                $replyRequest->data(),
                $ticket
            );

            Mail::to($ticketUpdate->email)->send(new TicketReplyMail($ticketUpdate));

            return redirect(route(self::INDEX_ROUTE))->withFlash([
                'type' => 'success',
                'title' => 'Ticket Saved',
                'message' => __('Ticket Reply Saved'),
            ]);

    }

}
