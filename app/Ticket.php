<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    //
    protected $fillable = ['random_id', 'seat_number', 'purchase_id', 'event_id', 'price_category_id'];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'random_id';
    }

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

    public function getRowAndSeat()
    {
        if( !$this->event->seatMap->layout ) {
            return null;
        }

        $counter = 0;
        $columnCounter = 0;
        $result = [];
        $rows = json_decode($this->event->seatMap->layout);
        foreach( $rows as $rowId => $row ) {
            $columnCounter = 0;
            foreach( str_split($row) as $charId => $char) {
                if($char === 'a') {
                    $counter++;
                    $columnCounter++;
                }
                if($counter === $this->seat_number) {
                    $result['row'] = $rowId+1;
                    $result['seat'] = $columnCounter;
                break;
                }
            }
        }
        return $result;
    }
}
