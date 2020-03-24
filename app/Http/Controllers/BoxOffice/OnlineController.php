<?php

namespace App\Http\Controllers\BoxOffice;

use App\Event;
use App\Http\Controllers\Controller;
use App\Http\Requests\SetBoxOfficeSales;
use App\Purchase;
use App\Ticket;
use Illuminate\Support\Str;

class OnlineController extends Controller
{
    public function index(Event $event)
    {
        return view('boxoffice.online', [
            'event' => $event,
            'tickets' => $event->tickets,
            'occupancy' => $event->getOccupancy(),
            'freeTickets' => $event->freeTickets(),
            'turnover' => $event->getTurnover()
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

    /**
     * This function sets the box office sales for an event. The sales are stored as a normal purchase
     * that is directly linked to this event object. Only this function should modify this purchase!
     * 
     * @param Event $event Is set by the route.
     * @param SetBoxOfficeSales $request post parameters containing the new amount of sold tickets per category
     */
    public function setBoxOfficeSales(Event $event, SetBoxOfficeSales $request)
    {
        // On the first call of this function the event has not an associated boxoffice purchase.
        // So we must create one.
        if(!$event->boxoffice) {
            $purchase = new Purchase();
            $purchase->generateSecrets();
            $purchase->customer_name = 'Box Office';
            $purchase->state = 'paid';
            $purchase->save();
            $event->boxoffice_id = $purchase->id;
            $event->save();
            $event->refresh();
        } else { // else fetch the existing boxoffice purchase
            $purchase = $event->boxoffice;
        }

        // For tracing: set always the latest box office submitter as responsible vendor
        $purchase->vendor_id = $request->user()->id;
        $purchase->save();

        // Delete all previously set tickets, because we recreate them by the new given set of categories
        Ticket::where('purchase_id', $purchase->id)->delete();

        // Freshly create the tickets sent for the box office
        foreach($request->tickets as $categoryId => $count) {
            for ($i = 0; $i < $count; $i++) {
                Ticket::create([
                    'random_id' => Str::random(32),
                    'seat_number' => 0, // Since it is the box office, they are responsible to sell only still available seats
                    'purchase_id' => $purchase->id,
                    'event_id' => $event->id,
                    'price_category_id' => $categoryId
                ]);
            }
        }

        return redirect()->route('boxoffice.online', $event);
    }
}
