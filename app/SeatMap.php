<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SeatMap extends Model
{
    protected $fillable = ['seats', 'name', 'description', 'layout'];

    public function events()
    {
        return $this->hasMany('App\Event');
    }
}
