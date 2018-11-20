<?php

namespace App\Http\Controllers\TicketShop;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Event;

class SeatMapController extends Controller
{
    /**
     * Receives id of event for which the user wants to buy tickets
     */
    public function selectSeats(Event $event)
    {
        return view('ticketshop.seatmap', ['event' => $event]);
    }
}