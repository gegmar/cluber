<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Location;
use App\PriceCategory;
use App\PriceList;
use App\SeatMap;
use Illuminate\Http\Request;

class SeatMapController extends Controller
{
    public function index()
    {
        return view('admin.dependencies.index', [
            'seatmaps' => SeatMap::all(),
            'locations' => Location::all(),
            'pricecategories' => PriceCategory::all(),
            'pricelists' => PriceList::all()
        ]);
    }

    public function showCreate()
    {

    }

    public function get() {

    }
}
