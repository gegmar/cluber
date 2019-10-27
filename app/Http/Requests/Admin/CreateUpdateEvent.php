<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CreateUpdateEvent extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Authorization is done in routes file
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'project'   => 'required|exists:projects,id',
            'name'      => 'required|string|max:255',
            'start'     => 'required|date_format:Y-m-d H:i:s',
            'end'       => 'required|date_format:Y-m-d H:i:s|after:start',
            'location'  => 'required|exists:locations,id',
            'seatmap'   => 'required|exists:seat_maps,id',
            'pricelist' => 'required|exists:price_lists,id'
        ];
    }
}
