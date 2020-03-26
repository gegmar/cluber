<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateUpdatePriceCategory;
use App\PriceCategory;
use Illuminate\Support\Facades\Log;

class PriceCategoryController extends Controller
{
    public function create(CreateUpdatePriceCategory $request)
    {
        $validated = $request->validated();
        $category = PriceCategory::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price']
        ]);
        // On successfull creation redirect the browser to the overview
        return redirect()
            ->route('admin.dependencies.prices.category.get', $category)
            ->with('status', 'Created ' . $category->name . '!');
    }

    public function get(PriceCategory $category)
    {
        return view('admin.dependencies.manage-price-category', ['category' => $category]);
    }

    public function update(PriceCategory $category, CreateUpdatePriceCategory $request)
    {
        $validated = $request->validated();

        $category->name = $validated['name'];
        $category->description = $validated['description'];
        $category->price = $validated['price'];
        $category->save();

        // On successfull update redirect the browser to the overview
        return redirect()
            ->route('admin.dependencies.prices.category.get', $category)
            ->with('status', 'Updated ' . $category->name . '!');
    }

    public function delete(PriceCategory $category)
    {
        Log::info('Deleting priceCategory#' . $category->id . ' (' . $category->name . ')');

        $category->delete();

        // On successfull deletion redirect the browser to the overview
        return redirect()
            ->route('admin.dependencies.dashboard')
            ->with('status', 'Deleted price category successfull!');
    }
}
