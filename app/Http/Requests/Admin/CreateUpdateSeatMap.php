<?php

namespace App\Http\Requests\Admin;

use App\Rules\SeatMapLayout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreateUpdateSeatMap extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->hasPermission('ADMINISTRATE');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'          => 'required|string|max:255',
            'description'   => 'required|string|max:255',
            'seats'         => 'required|numeric|min:0',
            'layout'        => new SeatMapLayout
        ];
    }
}
