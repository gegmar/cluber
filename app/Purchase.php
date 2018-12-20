<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    //
    protected $fillable = ['state', 'state_updated'];


    public function tickets()
    {
        return $this->hasMany('App\Tickets');
    }

    public function customer()
    {
        return $this->belongsTo('App\User', 'id', 'customer_id');
    }

    public function vendor()
    {
        return $this->belongsTo('App\User', 'id', 'vendor_id');
    }
}