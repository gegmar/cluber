<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Event;

class SelectTickets extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool Always true since this is a public function
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
            'tickets' => [
                'required',
                'array',
                function ($attribute, $value, $fail) {
                    $ticketSum = array_sum($value);
                    if ($ticketSum === 0) {
                        $fail('Please select at least one or up to 8 tickets!');
                    } elseif ($ticketSum > 8) {
                        $fail('Please select not more than 8 tickets!');
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

    /**
     * Overwrite error messages displayed on validition violation
     */
    public function messages()
    {
        return [
            'tickets.required' => 'Please select at least one or up to 8 tickets!',
        ];
    }
}