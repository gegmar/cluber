<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateUpdateSeatMap;
use App\Location;
use App\PriceCategory;
use App\PriceList;
use App\SeatMap;
use Illuminate\Support\Facades\Log;

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

    public function create(CreateUpdateSeatMap $request)
    {

    }

    public function get(SeatMap $seatMap)
    {
        return view('admin.dependencies.manage-seatmap', ['seatmap' => $seatMap]);
    }

    public function update(SeatMap $seatMap, CreateUpdateSeatMap $request)
    {

    }

    public function delete(SeatMap $seatMap)
    {
        Log::info('Deleting seatmap#' . $seatMap->id . ' (' . $seatMap->name . ')');

        $seatMap->delete();

        // On successfull deletion redirect the browser to the overview
        return redirect()
            ->route('admin.dependencies.dashboard')
            ->with('status', 'Deleted seatmap successfull!');
    }
}
