<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SetCustomerData extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool always true because this is a public function
     */
    public function authorize()
    {
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
            'name' => 'required|max:255|string',
            'email' => 'required|email|confirmed',
            'email_confirmation' => 'required',
            'terms' => 'required|accepted',
            'privacy' => 'required|accepted',
            'newsletter' => 'in:true',
        ];
    }
}