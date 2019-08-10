<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Purchase;
use App\Ticket;
use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Illuminate\Support\Facades\Log;

class TicketsController extends Controller
{
    protected $soldStates = ['paid', 'free', 'reserved'];

    public function showPurchase(Purchase $purchase)
    {
        if (!in_array($purchase->state, $this->soldStates)) {
            Log::warning('Someone tried to access unpaid tickets of purchase#' . $purchase->id);
            return redirect()->route('ts.events')->with('state', 'Error - Purchase has not been paid yet.');
        }

        return view('ticketshop.purchase-success', ['purchase' => $purchase]);
    }

    public function download(Purchase $purchase)
    {
        if (!in_array($purchase->state, $this->soldStates)) {
            Log::warning('Someone tried to access unpaid tickets of purchase#' . $purchase->id);
            return redirect()->route('ts.events')->with('state', 'Error - Purchase has not been paid yet.');
        }

        try {
            $html2pdf = new HTML2PDF('P', 'A4', 'de', true, 'UTF-8', 0);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->pdf->SetAuthor(config('app.name'));
            $html2pdf->pdf->SetTitle('Purchase #' . $purchase->id);

            // Add each ticket to the pdf
            foreach ($purchase->tickets as $ticket) {
                $content = view('pdfs.ticket', ['ticket' => $ticket])->render();
                $html2pdf->writeHTML($content);
            }

            $html2pdf->output('tickets-' . $purchase->id . '.pdf');
        } catch (Html2PdfException $e) {
            $html2pdf->clean();
            return redirect()->route('ticket.purchase', ['purchase' => $purchase])->with('state', $e->getMessage());
        }
    }

    /**
     * Displays a page showing if a ticket is valid or already invalidated.
     */
    public function showTicket(Ticket $ticket)
    {
        return view('ticketshop.ticket', ['ticket' => $ticket]);
    }
}
