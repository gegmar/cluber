<?php

namespace App\Http\Controllers\Retail;

use App\Http\Controllers\Controller;
use App\Purchase;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SoldTicketsController extends Controller
{
    public function getPurchases()
    {
        // not the nicest way to do it, but it works
        // Get a list of not already archived purchases by getting the archived projects
        $preFilteredPurchaseIds = DB::table('projects')
            ->join('events', 'projects.id', '=', 'events.project_id')
            ->join('tickets', 'events.id', '=', 'tickets.event_id')
            ->where('projects.is_archived', 0)
            ->distinct('tickets.purchase_id')
            ->pluck('tickets.purchase_id');

        // Use the previously fetched array of not archived purchase ids and
        // get the purchase models with additional filters applied
        $purchases = Purchase::where('vendor_id', auth()->user()->id)
            ->whereIn('state', ['paid', 'free', 'reserved'])
            ->whereIn('id', $preFilteredPurchaseIds)
            ->orderBy('state_updated', 'DESC')
            ->get();
        return view('retail.purchases', ['purchases' => $purchases]);
    }

    public function setToPaid(Purchase $purchase)
    {
        // First check if the soon-to-be-deleted purchase is
        // owned by the currently logged in user as vendor
        if (auth()->user()->id != $purchase->vendor_id) {
            return redirect()->route('retail.sold.tickets')->with('status', 'Error: You are not authorized!');
        }

        Log::info('[Retail user#' . Auth::user()->id . '] Setting state of purchase#' . $purchase->id . ' to "paid"');
        $purchase->state = 'paid';
        $purchase->save();

        return redirect()->route('ticket.purchase', $purchase)->with('status', 'Purchase successfully deleted!');
    }

    public function deletePurchase(Purchase $purchase)
    {
        // First check if the soon-to-be-deleted purchase is
        // owned by the currently logged in user as vendor
        if (auth()->user()->id != $purchase->vendor_id) {
            return redirect()->route('retail.sold.tickets')->with('status', 'Error: You are not authorized!');
        }

        Log::info('[Retail user#' . Auth::user()->id . '] Deleting purchase#' . $purchase->id);
        $purchase->deleteWithAllData();

        return redirect()->route('retail.sold.tickets')->with('status', 'Purchase successfully deleted!');
    }
}
