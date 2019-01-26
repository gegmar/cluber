<?php

namespace App\Http\Controllers\Retail;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Purchase;

class SoldTicketsController extends Controller
{
    public function getPurchases()
    {
        return view('errors.tbd');
    }

    public function getPurchase(Purchase $purchase)
    {

    }
}
