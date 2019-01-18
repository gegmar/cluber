<?php

namespace App\Http\Controllers\TicketShop;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CheckOutController extends Controller
{
    public function getOverview()
    {
        return view('errors.tbd');
    }

    public function getPaymentUrl()
    {
        return view('errors.tbd');
    }
}