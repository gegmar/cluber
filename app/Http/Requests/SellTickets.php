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
            'selected-seats' => [
                'sometimes',
                'required',
                'array',
                function ($attribute, $value, $fail) {
                    // We do not check if the amount of selected seats, because we already do this in the checks
                    // for the amount of tickets. Since the amount of tickets and seats
                    // has to be equal, the previous check implicits that the seats are
                    // free by the amount.
                    $seatsSum = count($value);
                    $event = $this->route('event');

                    // Check if number of tickets and seats is equal
                    $numberOfTickets = array_sum($this->validator->getData()['tickets']);
                    if ($seatsSum != $numberOfTickets) {
                        $fail('Please select as much seats as tickets!');
                    }

                    // Check if the seatIds are in the range of 1 - event's seats amount
                    $validSeats = array_filter($value, function ($arrItem) use ($event) {
                        return $arrItem > 0 && $arrItem <= $event->seatMap->seats;
                    });
                    if (count($validSeats) != $seatsSum) {
                        $fail('Please only select seats displayed on the map!');
                    }

                    // Check if the selected seats are still free
                    if (!$event->areSeatsFree($value)) {
                        $fail('There are not as many tickets as you chose left. Please only choose a valid amount of tickets!');
                    }
                }
            ]
        ];
    }
}
