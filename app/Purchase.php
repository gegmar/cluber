<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    //
    protected $fillable = ['state', 'state_updated'];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'state' => 'in_payment'
    ];

    public function total()
    {
        $tickets = $this->tickets;
        return $tickets->sum(function ($ticket) {
            return $ticket->price();
        });
    }

    public function tickets()
    {
        return $this->hasMany('App\Ticket');
    }

    public function customer()
    {
        return $this->belongsTo('App\User', 'id', 'customer_id');
    }

    public function vendor()
    {
        return $this->belongsTo('App\User', 'id', 'vendor_id');
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'random_id';
    }

    /**
     * Sets random_id and payment_secret
     */
    public function generateSecrets()
    {
        $this->state_updated = new \DateTime();
        $this->random_id = str_random(32);
        $this->payment_secret = str_random(32);
    }
}