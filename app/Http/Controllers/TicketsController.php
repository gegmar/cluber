<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Purchase;

class TicketsController extends Controller
{
    public function showPurchase(Purchase $purchase)
    {
        if ($purchase->state !== 'paid') {
            return redirect()->route('ts.events')->with('state', 'Error - Purchase has not been paid yet.');
        }

        return view('ticketshop.purchase-success', ['purchase' => $purchase]);
    }

    public function download(Purchase $purchase)
    {

    }
}
