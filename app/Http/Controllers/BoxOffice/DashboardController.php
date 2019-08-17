<?php

namespace App\Http\Controllers\BoxOffice;

use App\Http\Controllers\Controller;
use App\Event;
use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use App\Purchase;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $events = Event::where('state', 'open')->orderBy('start_date', 'ASC')->get();

        return view('boxoffice.dashboard', [
            'events' => $events
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
            return redirect()->route('boxoffice.dashboard')->with('state', $exc);
        }
    }
}
