<?php

namespace App\Http\Controllers\TicketShop;

use App\Http\Controllers\Controller;
use App\Http\Requests\SetCustomerData;

class CustomerDataController extends Controller
{
    /**
     * After the users selected some tickets, they must enter their
     * contact information to receive them after payment
     */
    public function getData()
    {
        // Check if all required previous inputs are present
        // Else sent user back to where he has to start/comence
        if (!session()->has('event')) {
            return redirect()->route('ts.events');
        }
        if (!session()->has('tickets')) {
            return redirect()->route('ts.seatmap', ['event' => session('event')->id]);
        }

        $data = [];
        if (session()->has('customerData')) {
            $data = session('customerData');
        }

        // data is structured like the form attributes in the view
        return view('ticketshop.customer-data', ['data' => $data]);
    }

    public function setData(SetCustomerData $request)
    {
        session(['customerData' => $request->validated()]);
        return redirect()->route('ts.overview');
    }
}