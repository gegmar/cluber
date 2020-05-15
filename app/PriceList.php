<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PriceList extends Model
{
    //
    protected $fillable = ['name'];

    public function events()
    {
        return $this->hasMany('App\Event');
    }

    public function categories()
    {
        return $this->belongsToMany('App\PriceCategory')->withPivot('priority');
    }
}
