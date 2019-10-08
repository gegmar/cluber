<?php

namespace App\Http\Controllers\Admin;

use App\Event;
use App\Http\Controllers\Controller;
use App\Purchase;
use App\Setting;
use App\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Mews\Purifier\Facades\Purifier;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Html2Pdf;

class SettingsController extends Controller
{
    // Display all available settings
    public function index()
    {
        $terms = Setting::where('name', 'terms')->where('lang', App::getLocale())->first();
        $termsHtml = $terms ? $terms->value : view('components.default-texts.terms')->render();

        $privacy = Setting::where('name', 'privacy')->where('lang', App::getLocale())->first();
        $privacyHtml = $privacy ? $privacy->value : view('components.default-texts.privacy')->render();

        return view('admin.settings', [
            'terms' => $termsHtml,
            'privacy' => $privacyHtml
        ]);
    }

    /**
     * Receives HTML-input
     * 
     * Attention: Function might be target for XSS attacks. Handle input carfully!!!
     */
    public function updateTerms(Request $request)
    {
        Setting::updateOrCreate(
            ['name' => 'terms', 'lang' => App::getLocale()],
            ['value' => Purifier::clean($request->input('terms'))]
        );
        return redirect()->route('admin.settings.dashboard')->with('state', 'Success - Terms and Conditions updated.');
    }

    /**
     * Receives HTML-input
     * 
     * Attention: Function might be target for XSS attacks. Handle input carfully!!!
     */
    public function updatePrivacy(Request $request)
    {
        Setting::updateOrCreate(
            ['name' => 'privacy', 'lang' => App::getLocale()],
            ['value' => Purifier::clean($request->input('privacy'))]
        );
        return redirect()->route('admin.settings.dashboard')->with('state', 'Success - Privacy statement updated.');
    }

    /**
     * File-Upload
     */
    public function updateLogo(Request $request)
    {
        $validatedFile = $request->validate([
            'file' => 'file|max:30000|mimes:jpeg,bmp,png,svg,jpg'
        ]);
        
        // Only extract file extension of the new logo picture
        $extension = $validatedFile['file']->extension();
        // set it to a generic name to overwrite any existing logo with the same extension
        $logoStoreName = 'logo.' . $extension;

        // Store file as new logo and update the corresponding setting
        $validatedFile['file']->storeAs('images', $logoStoreName);
        Setting::updateOrCreate(
            ['name' => 'logo', 'lang' => 'en'],
            ['value' => 'images/' . $logoStoreName]
        );

        // Redirect to source page with success message
        return redirect()->route('admin.settings.dashboard')->with('state', 'Success - Logo updated.');
    }

    /**
     * Returns a ticket filled with dummy data to check the
     * correct processing of the logo in the layout
     */
    public function testTicket()
    {
        // Wrap dummy data creation in a transaction in order
        // to not actually store it in the production database
        DB::beginTransaction();
        $purchase = factory(Purchase::class)->create();
        $event = factory(Event::class)->create();
        factory(Ticket::class, 7)->create([
            'event_id' => $event->id,
            'purchase_id' => $purchase->id
        ]);
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
            DB::rollBack();
            return redirect()->route('ticket.purchase', ['purchase' => $purchase])->with('state', $e->getMessage());
        }
        DB::rollBack();
    }
}
