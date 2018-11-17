<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    //
    protected $fillable = ['random_id', 'seat_number'];

    public function purchase()
    {
        return $this->belongsTo('App\Purchase');
    }

    public function event()
    {
        return $this->belongsTo('App\Event');
    }
}
