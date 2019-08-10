<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PayTickets extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool true always because it is a public accesible function
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
        $filter = 'in:';
        if(env('KLARNA_CONFIG_KEY')) {
            $filter .= 'Klarna,';
        }
        if(env('PAYPAL_CLIENT_SECRET')) {
            $filter .= 'PayPal,';
        }
        return [
            'paymethod' => [
                'required',
                $filter
            ]
        ];
    }
}
