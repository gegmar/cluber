<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Exceptions\PaymentProviderException;
use Illuminate\Support\Facades\Log;

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

    /**
     * Sum of all ticket prices included in the purchase
     */
    public function total()
    {
        $tickets = $this->tickets;
        return $tickets->sum(function ($ticket) {
            return $ticket->price();
        });
    }

    public function events()
    {
        $events = [];
        $this->tickets->each(function ($ticket) use (&$events) {
            $events[$ticket->event->id] = $ticket->event;
        });
        return collect($events);
    }

    /**
     * Prepare all tickets grouped by their priceCategory
     * for displaying in a view
     */
    public function ticketList()
    {
        $list = [];
        $this->tickets->each(function ($ticket) use (&$list) {
            if (array_key_exists($ticket->priceCategory->name, $list)) {
                $list[$ticket->priceCategory->name]['count']++;
            } else {
                $list[$ticket->priceCategory->name] = ['count' => 1, 'category' => $ticket->priceCategory];
            }
        });
        return collect($list);
    }

    /**
     * Deletes all associated data of the purchase and sets it to state=deleted
     * 
     * If the customer's user has other purchases connected,
     * the user will not be deleted.
     */
    public function deleteWithAllData()
    {
        $this->tickets->each(function ($ticket) {
            $ticket->delete();
        });

        $user = $this->customer;

        $this->state = "deleted";
        $this->state_updated = new \DateTime();
        $this->save();

        // If this purchase is the only purchase of the user,
        // and the user's password is empty, delete the user.
        if ($user && $user->purchases->count() === 1 && $user->password == '') {
            Log::info('Deleting customer "' . $user->name . '" (= #' . $user->id . ') of purchase #' . $this->id);
            $user->deleteWithRoles();
        }
    }

    public function setStateToPaid(string $secret)
    {
        // Validate if the sent secret matches the purchase-secret
        if ($this->payment_secret != $secret) {
            throw new PaymentProviderException('Error - Secret does not match purchase!');
        }

        $this->state = 'paid';
        $this->state_updated = new \DateTime();
        $this->save();
    }

    public function tickets()
    {
        return $this->hasMany('App\Ticket');
    }

    public function customer()
    {
        return $this->belongsTo('App\User', 'customer_id', 'id');
    }

    public function vendor()
    {
        return $this->belongsTo('App\User', 'vendor_id', 'id');
    }
}
