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
     * 
     */
    public function freeTickets()
    {
        return $this->seatMap->seats - $this->tickets->count();
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