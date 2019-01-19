<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PriceCategory extends Model
{
    public function priceLists()
    {
        return $this->belongsToMany('App\PriceList');
    }
}
