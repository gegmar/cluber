<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangeTicketState extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * Currently there are only global box office users, so the authorization done in the routes file is sufficient.
     *
     * @return bool
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
            'new_state' => 'required|in:open,consumed,no_show'
        ];
    }
}
