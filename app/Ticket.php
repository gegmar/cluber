<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    //
    protected $fillable = ['random_id', 'seat_number', 'purchase_id', 'event_id', 'price_category_id'];

    public function price()
    {
        return $this->priceCategory->price;
    }

    public function purchase()
    {
        return $this->belongsTo('App\Purchase');
    }

    public function event()
    {
        return $this->belongsTo('App\Event');
    }

    public function priceCategory()
    {
        return $this->belongsTo('App\PriceCategory');
    }
}
