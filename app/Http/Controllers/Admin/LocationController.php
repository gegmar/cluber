<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateUpdateLocation;
use App\Location;
use Illuminate\Support\Facades\Log;

class LocationController extends Controller
{
    public function create(CreateUpdateLocation $request)
    {
        $validated = $request->validated();
        $location = Location::create([
            'name' => $validated['name'],
            'address' => $validated['address']
        ]);
        // On successfull creation redirect the browser to the overview
        return redirect()
            ->route('admin.dependencies.location.get', $location)
            ->with('status', 'Created ' . $location->name . '!');
    }

    public function get(Location $location)
    {
        return view('admin.dependencies.manage-location', [
            'location' => $location
        ]);
    }

    public function update(Location $location, CreateUpdateLocation $request)
    {
        $validated = $request->validated();

        $location->name = $validated['name'];
        $location->address = $validated['address'];
        $location->save();

        // On successfull update redirect the browser to the overview
        return redirect()
            ->route('admin.dependencies.location.get', $location)
            ->with('status', 'Updated ' . $location->name . '!');
    }

    public function delete(Location $location)
    {
        Log::info('Deleting location#' . $location->id . ' (' . $location->name . ')');

        $location->delete();

        // On successfull deletion redirect the browser to the overview
        return redirect()
            ->route('admin.dependencies.dashboard')
            ->with('status', 'Deleted location successfull!');
    }
}
