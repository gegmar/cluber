<?php

namespace App\Http\Controllers\BoxOffice;

use App\Event;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChangeTicketState;
use App\Ticket;

class OnlineController extends Controller
{
    public function index(Event $event)
    {
        return view('boxoffice.online', [
            'event' => $event,
            'tickets' => $event->tickets
        ]);
    }

    public function changeTicketState(Ticket $ticket, ChangeTicketState $request)
    {
        $ticket->state = $request->new_state;
        $ticket->save();
        return response()->json([
            'state' => $request->new_state
        ]);
    }
}
