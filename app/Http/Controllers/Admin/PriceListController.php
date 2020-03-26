<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateUpdatePriceList;
use App\PriceCategory;
use App\PriceList;

class PriceListController extends Controller
{
    public function create(CreateUpdatePriceList $request)
    {
        $validated = $request->validated();
        $list = PriceList::create([
            'name' => $validated['name']
        ]);
        // On successfull creation redirect the browser to the object
        return redirect()
            ->route('admin.dependencies.prices.list.get', $list)
            ->with('status', 'Created ' . $list->name . '!');
    }

    public function get(PriceList $list)
    {
        return view('admin.dependencies.manage-price-list', [
            'list' => $list,
            'categories' => PriceCategory::all()
        ]);
    }

    public function update(PriceList $list, CreateUpdatePriceList $request)
    {
        $validated = $request->validated();

        // Set the new submitted (direct) list properties
        $list->name = $validated['name'];
        $list->save();

        // Detach all categories from the list
        $list->categories()->detach();

        // Attach only the given categories to the list
        $list->categories()->attach($validated['categories']);

        // On successfull update redirect the browser to the list object
        return redirect()
            ->route('admin.dependencies.prices.list.get', $list)
            ->with('status', 'Update successfull!');
    }

    public function delete(PriceList $list)
    {
        $list->categories()->detach();
        $list->delete();

        // On successfull deletion redirect the browser to the overview
        return redirect()
            ->route('admin.dependencies.dashboard')
            ->with('status', 'Deleted list successfull!');
    }
}
