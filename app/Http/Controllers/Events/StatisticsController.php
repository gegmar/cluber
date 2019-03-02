<?php

namespace App\Http\Controllers\Events;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Event;
use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use App\Purchase;

class StatisticsController extends Controller
{
    public function dashboard()
    {
        $upcomingEvents = Event::where('end_date', '>', new \DateTime())->orderBy('start_date', 'ASC')->take(5)->get();
        $openEvents = Event::where('end_date', '>', new \DateTime())->get();
        $mySales = Purchase::where('vendor_id', auth()->user()->id)->where('state', 'paid')->get();
        $totalSales = $mySales->count();
        $allSales = Purchase::where('state', 'paid')->count();
        $marketShare = round($totalSales * 100 / ($allSales > 0 ? $allSales : 1)); // Prevent a division by zero

        $myTurnOver = 0;
        foreach ($mySales as $purchase) {
            $myTurnOver += $purchase->total();
        }

        return view('events.dashboard', [
            'upcomingEvents' => $upcomingEvents,
            'openEvents' => $openEvents,
            'marketShare' => $marketShare,
            'totalSales' => $totalSales,
            'myTurnOver' => $myTurnOver
        ]);
    }

    public function downloadOverview(Event $event)
    {
        $tickets = $event->tickets()->orderBy('id', 'ASC')->get();

        try {
            $html2pdf = new HTML2PDF('P', 'A4', 'de', true, 'UTF-8', [20, 20, 20, 20]);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->pdf->SetAuthor(config('app.name'));
            $html2pdf->pdf->SetTitle('Ticket Overview');

            $content = view('pdfs.event', [
                'event' => $event,
                'tickets' => $tickets
            ])->render();
            $html2pdf->writeHTML($content);

            $html2pdf->output('overview-event-' . $event->id . '.pdf');
        } catch (Html2PdfException $exc) {
            $html2pdf->clean();
            return redirect()->route('events.dashboard')->with('state', $exc);
        }
    }
}
