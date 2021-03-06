<?php

namespace App\Http\Controllers\Admin;

use App\Event;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateUpdateEvent;
use App\Location;
use App\PriceCategory;
use App\PriceList;
use App\Project;
use App\Purchase;
use App\SeatMap;
use App\Ticket;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Html2Pdf;

class EventController extends Controller
{
    public function index()
    {
        $projects = Project::where('is_archived', false)->get();
        $archive = Project::where('is_archived', true)->get();
        foreach( $archive as $project )
        {
            // Set the time range of the project by selecting the last and first dates of its events
            // if no events are associated with the project, set the dates to '-'
            $firstEvent = $project->events()->orderBy('start_date', 'ASC')->first();
            $project->start_date = $firstEvent === null ? '-' : $firstEvent->start_date;
            $lastEvent = $project->events()->orderBy('end_date', 'DESC')->first();
            $project->end_date = $lastEvent === null ? '-' : $lastEvent->end_date;
        }

        $events = Event::whereHas('project', function(Builder $query) {
            $query->where('is_archived', false);
        })->get();

        return view('admin.events.index', [
            'projects' => $projects,
            'events'   => $events,
            'archived' => $archive
        ]);
    }

    public function showCreate()
    {
        $projects = Project::where('is_archived', false)->orderBy('name', 'ASC')->get();
        $archive = Project::where('is_archived', true)->orderBy('name', 'ASC')->get();
        $locations = Location::orderBy('name', 'ASC')->get();
        $seatMaps = SeatMap::orderBy('name', 'ASC')->get();
        $priceLists = PriceList::orderBy('name', 'ASC')->get();

        return view('admin.events.manage-event', [
            'create' => true,
            'projects' => $projects,
            'archive' => $archive,
            'locations' => $locations,
            'seatmaps' => $seatMaps,
            'pricelists' => $priceLists
        ]);
    }

    public function create(CreateUpdateEvent $request)
    {
        $event = new Event();
        $event->project_id = $request->project;
        $event->second_name = $request->name;
        $event->start_date = $request->start;
        $event->end_date = $request->end;
        $event->retailer_sell_stop = $request->retailer_sell_stop;
        $event->customer_sell_stop = $request->customer_sell_stop;
        $event->location_id = $request->location;
        $event->seat_map_id = $request->seatmap;
        $event->price_list_id = $request->pricelist;
        $event->save();

        return redirect()->route('admin.events.get', $event)
                ->with('status', 'Updated Event successfully!');
    }

    public function get(Event $event)
    {
        $projects = Project::where('is_archived', false)->orderBy('name', 'ASC')->get();
        $archive = Project::where('is_archived', true)->orderBy('name', 'ASC')->get();
        $locations = Location::orderBy('name', 'ASC')->get();
        $seatMaps = SeatMap::orderBy('name', 'ASC')->get();
        $priceLists = PriceList::orderBy('name', 'ASC')->get();

        return view('admin.events.manage-event', [
            'create' => false,
            'event' => $event,
            'projects' => $projects,
            'archive' => $archive,
            'locations' => $locations,
            'seatmaps' => $seatMaps,
            'pricelists' => $priceLists
        ]);
    }

    public function update(Event $event, CreateUpdateEvent $request)
    {
        $event->project_id = $request->project;
        $event->second_name = $request->name;
        $event->start_date = $request->start;
        $event->end_date = $request->end;
        $event->retailer_sell_stop = $request->retailer_sell_stop;
        $event->customer_sell_stop = $request->customer_sell_stop;
        $event->location_id = $request->location;
        $event->seat_map_id = $request->seatmap;
        $event->price_list_id = $request->pricelist;
        $event->save();

        return redirect()->route('admin.events.get', $event)
                ->with('status', 'Updated Event successfully!');
    }

    public function delete(Event $event)
    {
        if($event->tickets()->exists())
        {
            return redirect()->route('admin.events.get', $event)
                    ->with('status', 'Error on deletion: Event has tickets!');
        }
        $event->delete();
        return redirect()->route('admin.events.dashboard')
                        ->with('status', 'Deleted Event successfully!');
    }

    /**
     * Returns a ticket filled with dummy data to check the
     * correct processing of the logo in the layout
     */
    public function testTicket(Event $event, Request $request)
    {
        // Wrap dummy data creation in a transaction in order
        // to not actually store it in the production database.
        //
        // We have to use eloquent models and cannot use factories,
        // because factories are not available on prod installations.
        DB::beginTransaction();
        $now = now();

        $purchase = new Purchase();
        $purchase->state = 'paid';
        $purchase->state_updated = $now;
        $purchase->random_id = Str::random(20);
        $purchase->payment_secret = Str::random(20);
        $purchase->customer_id = Auth::user()->id;
        $purchase->vendor_id = Auth::user()->id;
        $purchase->payment_id = 'dummy-reference';
        $purchase->save();

        $backupPriceCategory = PriceCategory::create([
            'name'        => 'StandardPrice',
            'price'       => 40,
            'description' => 'Default Standard pricing'
        ]);
        
        for($i = 0; $i < 8; $i++) {
            $ticket = new Ticket();
            $ticket->random_id         = Str::random(20);
            $ticket->seat_number       = $i + 1000;
            $ticket->event_id          = $event->id;
            $ticket->purchase_id       = $purchase->id;
            // If the event already has a pricelist attached use the first item of it. Else use the backup price category
            $ticket->price_category_id = $event->priceList->categories ? $event->priceList->categories[0]->id : $backupPriceCategory->id;
            $ticket->state             = 'consumed';
            $ticket->save();
        }
        try {
            $html2pdf = new HTML2PDF('P', 'A4', 'de', true, 'UTF-8', 0);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->pdf->SetAuthor(config('app.name'));
            $html2pdf->pdf->SetTitle('Purchase #' . $purchase->id);

            // Generate pdf-content by passing the tickets to the view
            $content = view('pdfs.ticket-v2', ['tickets' => $purchase->tickets])->render();
            $html2pdf->writeHTML($content);

            $html2pdf->output('tickets-' . $purchase->id . '.pdf');
        } catch (Html2PdfException $e) {
            $html2pdf->clean();
            DB::rollBack();
            return redirect()->route('ticket.purchase', ['purchase' => $purchase])->with('state', $e->getMessage());
        }
        DB::rollBack();
    }
}
