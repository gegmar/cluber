<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Purchase;
use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Exception\ExceptionFormatter;
use Illuminate\Support\Facades\Log;

class TicketsPaid extends Mailable
{
    use Queueable, SerializesModels;

    public $purchase;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Purchase $purchase)
    {
        $this->purchase = $purchase;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        try {
            $html2pdf = new HTML2PDF('P', 'A4', 'de', true, 'UTF-8', 0);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->pdf->SetAuthor(config('app.name'));
            $html2pdf->pdf->SetTitle('Purchase #' . $this->purchase->id);

            // Add each ticket to the pdf
            foreach ($this->purchase->tickets as $ticket) {
                $content = view('pdfs.ticket', ['ticket' => $ticket])->render();
                $html2pdf->writeHTML($content);
            }

            $pdfContent = $html2pdf->output('tickets-' . $this->purchase->id . '.pdf', 'S');

            return $this->markdown('mails.tickets.paid')
                ->attachData($pdfContent, 'tickets-' . $this->purchase->id . '.pdf', [
                    'mime' => 'application/pdf',
                ]);;
        } catch (Html2PdfException $e) {
            $html2pdf->clean();
            $formatter = new ExceptionFormatter($e);
            $errorText = $formatter->getHtmlMessage();
            Log::error($errorText);
            return $this->markdown('mails.tickets.paid');
        }


    }
}
