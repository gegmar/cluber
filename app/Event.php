<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    //
    protected $fillable = ['start_date', 'end_date', 'second_name'];

    /**
     * Returns true, if no more tickets for this event are available
     */
    public function isSoldOut()
    {
        return $this->tickets->count() >= $this->seatMap->seats;
    }

    /**
     * Returns number of free tickets of an event
     */
    public function freeTickets()
    {
        return $this->seatMap->seats - $this->tickets->count();
    }

    /**
     * Returns true if the given array of seat ids is still free / not already booked
     */
    public function areSeatsFree(array $requestedSeats): bool
    {
        $bookedSeats = $this->tickets()->whereIn('seat_number', $requestedSeats)->get();
        return $bookedSeats->isEmpty();
    }

    /**
     * Local scopes & relations
     */


    public function scopeEnded($query)
    {
        return $query->where('end_date', '<', new \DateTime());
    }

    public function scopeOpen($query)
    {
        return $query->where('start_date', '>', new \DateTime());
    }



    public function tickets()
    {
        return $this->hasMany('App\Ticket');
    }

    public function project()
    {
        return $this->belongsTo('App\Project');
    }

    public function location()
    {
        return $this->belongsTo('App\Location');
    }

    public function seatMap()
    {
        return $this->belongsTo('App\SeatMap');
    }

    public function priceList()
    {
        return $this->belongsTo('App\PriceList');
    }
}
