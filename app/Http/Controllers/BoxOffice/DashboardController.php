<?php

namespace App\Http\Controllers\BoxOffice;

use App\Http\Controllers\Controller;
use App\Event;
use App\Project;
use Illuminate\Support\Facades\DB;
use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $activeProjectIds = Project::where('is_archived', 0)->pluck('id');
        $events = Event::whereIn('project_id', $activeProjectIds)->where('state', 'open')->orderBy('start_date', 'ASC')->get();

        return view('boxoffice.dashboard', [
            'events' => $events
        ]);
    }

    public function downloadOverview(Event $event)
    {
        $tickets = $event->tickets()->orderBy('id', 'ASC')->get();
        $overview = DB::table('tickets')
            ->join('purchases', 'tickets.purchase_id', '=', 'purchases.id')
            ->join('users', 'purchases.vendor_id', '=', 'users.id')
            ->join('price_categories', 'price_categories.id', '=', 'tickets.price_category_id')
            ->where('tickets.event_id', $event->id)
            ->groupBy('users.name', 'price_categories.name', 'price_categories.price')
            ->select(DB::raw(
                "users.name AS 'vendor',
                price_categories.name AS 'category',
                price_categories.price AS 'price',
                COUNT(CASE purchases.state when 'paid' then 1 else null end) AS 'paid',
                COUNT(CASE purchases.state when 'reserved' then 1 else null end) AS 'reserved',
                COUNT(CASE purchases.state when 'free' then 1 else null end) AS 'free',
                COUNT(purchases.state) AS 'sum'"
            ))
            ->get();
        $sums = DB::table('tickets')
            ->join('purchases', 'tickets.purchase_id', '=', 'purchases.id')
            ->where('tickets.event_id', $event->id)
            ->select(DB::raw(
                "SUM(CASE purchases.state when 'paid' then 1 else null end) AS 'paid',
                SUM(CASE purchases.state when 'reserved' then 1 else null end) AS 'reserved',
                SUM(CASE purchases.state when 'free' then 1 else null end) AS 'free',
                COUNT(purchases.state) AS 'sum'"
            ))
            ->get();

        try {
            $html2pdf = new HTML2PDF('P', 'A4', 'de', true, 'UTF-8', [20, 20, 20, 20]);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->pdf->SetAuthor(config('app.name'));
            $html2pdf->pdf->SetTitle('Ticket Overview');

            $content = view('pdfs.event', [
                'event'    => $event,
                'tickets'  => $tickets,
                'overview' => $overview,
                'sums'     => $sums
            ])->render();
            $html2pdf->writeHTML($content);

            $html2pdf->output('overview-event-' . $event->id . '.pdf');
        } catch (Html2PdfException $exc) {
            $html2pdf->clean();
            return redirect()->route('boxoffice.dashboard')->with('state', $exc);
        }
    }
}
