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
            ->where('state', 'paid')
            ->orderBy('state_updated', 'DESC')
            ->get();
        return view('retail.purchases', ['purchases' => $purchases]);
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