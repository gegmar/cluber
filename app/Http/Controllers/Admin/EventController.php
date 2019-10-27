<?php

namespace App\Http\Controllers\Admin;

use App\Event;
use App\Http\Controllers\Controller;
use App\Project;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class EventController extends Controller
{
    //
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

    public function create()
    {
        return "TODO";
    }

    public function get(Event $event)
    {
        return "TODO";
    }

    public function update(Event $event)
    {
        return "TODO";
    }

    public function delete(Event $event)
    {
        return "TODO";
    }
}
