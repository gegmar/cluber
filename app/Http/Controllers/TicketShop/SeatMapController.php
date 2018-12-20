<?php

namespace App\Http\Controllers\TicketShop;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Event;
use App\Purchase;
use App\Ticket;

class SeatMapController extends Controller
{
    /**
     * Receives id of event for which the user wants to buy tickets
     */
    public function selectSeats(Event $event)
    {
        $tickets = $event->purchases()->tickets()->get();
        return view('ticketshop.seatmap', ['event' => $event]);
    }


    public function seatsSelected(Event $event, Request $request)
    {
        return redirect('');
    }
}