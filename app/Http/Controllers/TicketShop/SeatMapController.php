<?php

namespace App\Http\Controllers\TicketShop;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Event;
use App\Http\Requests\SelectTickets;

class SeatMapController extends Controller
{
    /**
     * Receives id of event for which the user wants to buy tickets
     */
    public function getSeats(Request $request, Event $event)
    {
        $seatMapView = 'ticketshop.seatmaps.seatmap-js';
        if ($event->seatMap->layout === null) {
            $seatMapView = 'ticketshop.seatmaps.no-seats';
        }

        // Only set already chosen tickets, if they have been selected for the same event
        $tickets = null;
        if (session()->has('event') && $event->id === session('event')->id) {
            $tickets = $request->session()->get('tickets');
        }

        // TODO: Bug@countValidation
        return view($seatMapView, ['event' => $event, 'tickets' => $tickets]);
    }

    /**
     * Receives number of tickets per category and optionally
     * the seat ids of the selected seats
     */
    public function setSeats(SelectTickets $request, Event $event)
    {
        if ($event->seatMap->layout !== null) {
            // handle seat ids
            // TODO for later
        }

        $validated = $request->validated();
        session(['tickets' => $validated['tickets']]);
        session(['event' => $event]);


        return redirect()->route('ts.customerData');
    }

}