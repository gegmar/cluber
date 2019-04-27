<?php

namespace App\Http\Controllers\Retail;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Purchase;

class SoldTicketsController extends Controller
{
    public function getPurchases()
    {
        $purchases = Purchase::where('vendor_id', auth()->user()->id)
            ->whereIn('state', ['paid', 'free', 'reserved'])
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

        $purchase->deleteWithAllData();

        return redirect()->route('retail.sold.tickets')->with('status', 'Purchase successfully deleted!');
    }
}
