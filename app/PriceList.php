<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PriceList extends Model
{
    //
    protected $fillable = ['name', 'prices'];

    public function events()
    {
        return $this->hasMany('App\Event');
    }
}
