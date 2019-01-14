<?php

namespace App\Http\Controllers\TicketShop;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Project;
use App\Event;

class EventsController extends Controller
{
    /**
     * Show the starting page of the ticket shop.
     * 
     * Works for both guests and authenticated users.
     * 
     * Displays all current projects and events.
     */
    public function index()
    {
        $projects = Project::with(['events' => function ($query) {
            $query->where('start_date', '>=', new \DateTime());
        }, 'events.location'])->get();

        $currentProjects = $projects->filter(function ($project) {
            return $project->events->count() > 0;
        })->all();

        return view('ticketshop.events', ['projects' => $currentProjects]);
    }
}