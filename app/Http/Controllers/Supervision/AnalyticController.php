<?php

namespace App\Http\Controllers\Supervision;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Event;
use App\Purchase;
use App\Project;
use App\Ticket;

class AnalyticController extends Controller
{

    public function dashboard()
    {
        $projects = Project::get();

        $events = Event::get();
        $totalEvents = $events->count();

        $totalSeats = 0;
        foreach ($events as $event) {
            $totalSeats += $event->seatMap->seats;
        }
        $soldTickets = Ticket::get()->count();
        $load = round(($soldTickets / $totalSeats) * 100, 0);

        $sales = Purchase::where('state', 'paid')->get();
        $totalSales = $sales->count();

        $turnover = 0;
        foreach ($sales as $purchase) {
            $turnover += $purchase->total();
        }

        return view('supervision.dashboard', [
            'projects' => $projects,
            'totalEvents' => $totalEvents,
            'totalSales' => $totalSales,
            'turnover' => $turnover,
            'load' => $load,
        ]);
    }

    public function downloadCSV(Project $project)
    {
        return response()->streamDownload(function () use ($project) {
            echo view('csvs.tickets', ['events' => $project->events])->render();
        }, 'export.csv');
    }
}
