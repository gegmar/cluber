<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    //
    protected $fillable = ['name', 'address'];

    public function events()
    {
        return $this->hasMany('App\Event');
    }
}
