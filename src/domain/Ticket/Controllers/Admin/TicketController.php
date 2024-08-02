<?php

namespace Domain\Ticket\Controllers\Admin;

use App\Http\Controllers\Controller;
use Domain\Ticket\Actions\ListTicketsAction;
use Domain\Ticket\ViewModels\TicketViewModel;
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

}
