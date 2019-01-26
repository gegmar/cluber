<?php

namespace App\Http\Controllers\Retail;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Project;
use App\Event;
use App\Http\Requests\SellTickets;

class SellTicketsController extends Controller
{
    /**
     * Display all available events
     */
    public function events()
    {
        $projects = Project::with(['events' => function ($query) {
            $query->where('start_date', '>=', new \DateTime())->orderBy('start_date', 'ASC');
        }, 'events.location'])->get();

        $currentProjects = $projects->filter(function ($project) {
            return $project->events->count() > 0;
        })->all();

        return view('retail.events', ['projects' => $currentProjects]);
    }

    /**
     * Display available price categories for the selected event
     */
    public function seats(Request $request, Event $event)
    {
        $seatMapView = 'retail.seatmaps.seatmap-js';
        if ($event->seatMap->layout === null) {
            $seatMapView = 'retail.seatmaps.no-seats';
        }

        // Only set already chosen tickets, if they have been selected for the same event
        $tickets = null;
        if (session()->has('event') && $event->id === session('event')->id) {
            $tickets = $request->session()->get('tickets');
        }

        return view($seatMapView, ['event' => $event, 'tickets' => $tickets]);
    }

    /**
     * Create a paid purchase mapped on the current logged in user as vendor
     */
    public function sellTickets(SellTickets $request)
    {

    }
}
