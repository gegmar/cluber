<?php

namespace App\Http\Controllers\TicketShop;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Project;
use App\Event;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;

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
        // Cleanup lost orders all 5 minutes
        if (!Cache::has('deletedLostOrders')) {
            $expiresAt = now()->addMinutes(5);
            Artisan::call('app:deleteLostOrders');
            Cache::put('deletedLostOrders', '1', $expiresAt);
        }

        $projects = Project::with(['events' => function ($query) {
            $query->where('start_date', '>=', new \DateTime())->orderBy('start_date', 'ASC');
        }, 'events.location'])->get();

        $currentProjects = $projects->filter(function ($project) {
            return $project->events->count() > 0;
        })->all();

        return view('ticketshop.events', ['projects' => $currentProjects]);
    }
}