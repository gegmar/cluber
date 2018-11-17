<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SeatMap extends Model
{
    protected $fillable = ['rows', 'columns', 'name', 'description'];

    public function events()
    {
        return $this->hasMany('App\Event');
    }
}
