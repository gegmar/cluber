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
        // Creation is always without a layout
        $validated = $request->validated();
        $seatMap = SeatMap::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'seats' => $validated['seats']
        ]);
        // On successfull creation redirect the browser to the overview
        return redirect()
            ->route('admin.dependencies.seatmap.get', $seatMap)
            ->with('status', 'Created ' . $seatMap->name . '!');
    }

    public function get(SeatMap $seatMap)
    {
        return view('admin.dependencies.manage-seatmap', ['seatmap' => $seatMap]);
    }

    public function update(SeatMap $seatMap, CreateUpdateSeatMap $request)
    {
        $validated = $request->validated();

        $seatMap->name = $validated['name'];
        $seatMap->description = $validated['description'];
        $seatMap->seats = $validated['seats'];

        if( !empty(json_decode($validated['layout'])) )
        {
            $numberOfSeatsInLayout = preg_match_all('/a/', $validated['layout']);
            if($numberOfSeatsInLayout != $validated['seats']) {
                return redirect()
                    ->route('admin.dependencies.seatmap.get', $seatMap)
                    ->with('status', 'Counted seats of layout (' . $numberOfSeatsInLayout . ') does not match the given seats (' . $validated['seats'] . ')!');
            }
            $seatMap->layout = $validated['layout'];
        } else {
            $seatMap->layout = null;
        }

        $seatMap->save();

        // On successfull update redirect the browser to the overview
        return redirect()
            ->route('admin.dependencies.seatmap.get', $seatMap)
            ->with('status', 'Updated ' . $seatMap->name . '!');
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
