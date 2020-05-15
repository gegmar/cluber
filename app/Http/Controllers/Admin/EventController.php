<?php

namespace App\Http\Controllers\Admin;

use App\Event;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateUpdateEvent;
use App\Location;
use App\PriceList;
use App\Project;
use App\SeatMap;
use Illuminate\Database\Eloquent\Builder;

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
}
