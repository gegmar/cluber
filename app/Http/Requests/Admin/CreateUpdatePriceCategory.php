<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreateUpdatePriceCategory extends FormRequest
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
            'price'         => 'required|regex:/[\d]{1,7}.[\d]{2}/' // Only accept positiv decimals from 0,00 to 9999999,99
        ];
    }
}
