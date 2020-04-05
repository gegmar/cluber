<?php

namespace App\Http\Controllers;

use App\Purchase;
use App\Ticket;
use App\User;
use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Illuminate\Support\Facades\Log;

class TicketsController extends Controller
{
    protected $soldStates = ['paid', 'free', 'reserved'];

    /**
     * Show an overview of the given purchase
     */
    public function showPurchase(Purchase $purchase)
    {
        $mollie = User::firstWhere('email', 'mollie@system.local');
        return view('ticketshop.purchase-success', [
            'purchase' => $purchase,
            'mollie'   => $mollie->id
        ]);
    }

    /**
     * Provide a purchase's tickets as a pdf download
     */
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

            // Generate pdf-content by passing the tickets to the view
            $content = view('pdfs.ticket-v2', ['tickets' => $purchase->tickets])->render();
            $html2pdf->writeHTML($content);

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
