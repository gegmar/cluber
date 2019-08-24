<?php

namespace App\Http\Controllers\BoxOffice;

use App\Event;
use App\Http\Controllers\Controller;
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

    public function switchTicketState(Ticket $ticket)
    {
        if($ticket->state == 'no_show') {
            $ticket->state = 'consumed';
        } else {
            $ticket->state = 'no_show';
        }
        $ticket->save();
        
        return response()->json([
            'state' => $ticket->state
        ]);
    }
}
