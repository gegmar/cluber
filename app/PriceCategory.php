<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PriceCategory extends Model
{
    
    protected $fillable = ['name', 'description', 'price'];

    public function priceLists()
    {
        return $this->belongsToMany('App\PriceList')->withPivot('priority');
    }

    public function tickets()
    {
        return $this->belongsToMany('App\Ticket');
    }
}
