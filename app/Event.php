<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    //
    protected $fillable = ['start_date', 'end_date', 'second_name'];

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
