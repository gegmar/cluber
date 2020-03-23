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
        $projects = Project::where('is_archived', 0)->get();

        $events = Event::whereIn('project_id', $projects->pluck('id'))->get();
        $totalEvents = $events->count();

        $totalSeats = 0;
        foreach ($events as $event) {
            $totalSeats += $event->seatMap->seats;
        }
        // Only fetch the purchase_ids for filtering the later query for relevant purchases
        $tickets = Ticket::whereIn('event_id', $events->pluck('id'))->pluck('purchase_id');
        $soldTickets = $tickets->count();
        $load = round(($soldTickets / $totalSeats) * 100, 0);

        // Prefilter the purchases on the filtered tickets
        $distinctPurchaseIds = $tickets->toArray();
        $distinctPurchaseIds = array_unique($distinctPurchaseIds, SORT_NUMERIC);
        $sales = Purchase::whereIn('id', $tickets)->where('state', 'paid')->get();
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

    public function downloadHelgaMetrics(Project $project)
    {
        return response()->streamDownload(function() use ($project) {
            echo view('csvs.helga-metrics', ['data' => $project->getHelgaMetrics()])->render();
        }, 'helgaMetrics.csv');
    }
}
