<?php

namespace App\Http\Controllers\TicketShop;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CheckOutController extends Controller
{
    public function getOverview()
    {
        // Only allow requests for sessions with existing customer data
        if (!session()->has('customerData')) {
            return redirect()->route('ts.customerData');
        }

        $cData = session('customerData');

        return view('ticketshop.purchase-overview', [
            'event' => session('event'),
            'tickets' => session('tickets'),
            'customerData' => session('customerData'),
        ]);
    }

    public function getPaymentUrl()
    {
        return view('errors.tbd');
    }
}