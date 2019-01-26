<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SellTickets extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
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
                    $ticketSum = array_sum($value);
                    if ($ticketSum === 0) {
                        $fail('Please select at least one or up to 8 tickets!');
                    }
                    $event = $this->route('event');
                    if ($event->freeTickets() < $ticketSum) {
                        $fail('There are not as many tickets as you chose left. Please only choose a valid amount of tickets!');
                    }
                }
            ],
            'seat-ids' => 'array'
        ];
    }
}
