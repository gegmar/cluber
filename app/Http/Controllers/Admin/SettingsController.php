<?php

namespace App\Http\Controllers\Admin;

use App\Event;
use App\Http\Controllers\Controller;
use App\Location;
use App\PriceCategory;
use App\PriceList;
use App\Project;
use App\Purchase;
use App\SeatMap;
use App\Setting;
use App\Ticket;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
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

    // Purge the current logo
    public function deleteLogo(Request $request)
    {
        Setting::where([
            ['name', 'logo'],
            ['lang', 'en']
        ])->delete();
        // Redirect to source page with success message
        return redirect()->route('admin.settings.dashboard')->with('state', 'Success - Logo deleted.');
    }

    /**
     * Returns a ticket filled with dummy data to check the
     * correct processing of the logo in the layout
     */
    public function testTicket()
    {
        // Wrap dummy data creation in a transaction in order
        // to not actually store it in the production database.
        //
        // We have to use eloquent models and cannot use factories,
        // because factories are not available on prod installations.
        DB::beginTransaction();
        $vendor = User::create([
            'name'     => 'TestVendor FamilynameOfVendor',
            'email'    => 'vendor@testing.local',
            'password' => ''
        ]);
        $customer = User::create([
            'name'     => 'Avery LongName ButItShouldWork',
            'email'    => 'alsoverylong.nameforamail@testing.local',
            'password' => ''
        ]);

        $priceList = PriceList::create([
            'name' => 'Testlist'
        ]);
        $priceCategory = PriceCategory::create([
            'name'        => 'TestCategory',
            'price'       => 450,
            'description' => 'Just for testing the ticket layout'
        ]);
        $priceList->categories()->save($priceCategory);

        $location = Location::create([
            'name'    => 'Some Test Location anywhere',
            'address' => 'Somewhere over the rainbox street 42, 424242 Kummerland, Wilde13'
        ]);
        $project = Project::create([
            'name'        => 'A Test project',
            'description' => 'Something something testing',
            'is_archived' => false
        ]);
        $seatMap = SeatMap::create([
            'name'        => 'TestSeatMap',
            'seats'       => 2000,
            'description' => 'Some test description that does not really matter',
            'layout'      => null
        ]);
        $now = now();

        $purchase = new Purchase();
        $purchase->state = 'paid';
        $purchase->state_updated = $now;
        $purchase->random_id = Str::random(20);
        $purchase->payment_secret = Str::random(20);
        $purchase->customer_id = $customer->id;
        $purchase->vendor_id = $vendor->id;
        $purchase->payment_id = 'dummy-reference';
        $purchase->save();

        $event = new Event();
        $event->second_name        = 'First event';
        $event->customer_sell_stop = $now->add(1, 'day');
        $event->retailer_sell_stop = $now->add(2, 'day');
        $event->start_date         = $now->add(1, 'day');
        $event->end_date           = $now->add(10, 'day');
        $event->project_id         = $project->id;
        $event->location_id        = $location->id;
        $event->seat_map_id        = $seatMap->id;
        $event->price_list_id      = $priceList->id;
        $event->state              = 'open';
        $event->save();

        for ($i = 0; $i < 8; $i++) {
            $ticket = new Ticket();
            $ticket->random_id         = Str::random(20);
            $ticket->seat_number       = $i + 1000;
            $ticket->event_id          = $event->id;
            $ticket->purchase_id       = $purchase->id;
            $ticket->price_category_id = $priceCategory->id;
            $ticket->state             = 'consumed';
            $ticket->save();
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
            DB::rollBack();
            return redirect()->route('ticket.purchase', ['purchase' => $purchase])->with('state', $e->getMessage());
        }
        DB::rollBack();
    }
}
