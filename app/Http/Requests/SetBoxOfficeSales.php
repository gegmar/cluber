<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\PriceCategory;

class SetBoxOfficeSales extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->hasPermission('SELL_TICKETS');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'tickets' => [
                'required',
                'array',
                function ($attribute, $value, $fail) {
                    foreach ($value as $category => $count) {
                        if (!PriceCategory::find($category)) {
                            $fail('Please select only offered price categories!');
                        }
                    }
                }
            ]
        ];
    }
}
