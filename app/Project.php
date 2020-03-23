<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Project extends Model
{
    //
    protected $fillable = ['name', 'description'];

    public function events()
    {
        return $this->hasMany('App\Event');
    }

    /**
     * Return a table with the metrics the Theater in der Werkstatt (Kirchdorf) needs for analysis
     * 
     * Header of table:
     * - Event date
     * - free tickets
     * - count of ticket type #x
     * - count of no shows of ticket type #x
     * - sum of ticket type #x
     * - count all tickets
     * - sum all sold tickets
     * - sum sold tickets by vendor
     * - Box Office sales
     * - no-shows
     * 
     * @return void 
     */
    public function getHelgaMetrics()
    {
        // Challenges on generating these stats:
        // 1. variable amount of vendors and price categories used per event
        // 2. Substract box office sales from regular sales
        
        $result = [];

        // Get all event-ids of the project
        $eventIds = $this->events()->pluck('id');

        // base query that joins all required tables to one big table of tickets
        $viewQuery = DB::table('tickets')
                        ->join('price_categories', 'tickets.price_category_id', '=', 'price_categories.id')
                        ->join('purchases', 'tickets.purchase_id', '=', 'purchases.id')
                        ->join('users', 'purchases.vendor_id', '=', 'users.id');

        // First we fetch the result-table-headers. By using "with()" we can reuse the base query for all other queries.
        // + Group by price categories
        // + Group by vendors
        $priceCategories = with(clone $viewQuery)->whereIn('tickets.event_id', $eventIds)
                                        ->groupBy('price_categories.id')
                                        ->select('price_categories.id as id', 'price_categories.name as name')
                                        ->get();

        $vendors = with(clone $viewQuery)->whereIn('tickets.event_id', $eventIds)
                            ->groupBy('purchases.vendor_id')
                            ->select('users.id as id', 'users.name as name')
                            ->get();
        
        // Iterate over all events and fill in the values for each fetched header
        foreach( $this->events as $event ) {
            $eventResults = [];

            $eventResults['date'] = $event->start_date;

            // Set free tickets
            $eventResults['free_tickets'] = with(clone $viewQuery)->where('tickets.event_id', $event->id)
                                                                ->where('purchases.state', 'free')
                                                                ->count();

            // Get ticket category stats
            foreach( $priceCategories as $cat) {
                // Get the number of tickets sold of this category
                $eventResults[$cat->name . '_total'] = with(clone $viewQuery)->where('tickets.event_id', $event->id)
                                                                            ->where('purchases.state', 'paid')
                                                                            ->where('price_categories.id', $cat->id)
                                                                            ->count();
                // Get the amount of money by sold tickets of this category
                $eventResults[$cat->name . '_sum'] = with(clone $viewQuery)->where('tickets.event_id', $event->id)
                                                                            ->where('purchases.state', 'paid')
                                                                            ->where('price_categories.id', $cat->id)
                                                                            ->sum('price_categories.price');
                // Get the number of not consumed tickets (=no shows)
                $eventResults[$cat->name . '_no-show'] = with(clone $viewQuery)->where('tickets.event_id', $event->id)
                                                                            ->where('purchases.state', 'paid')
                                                                            ->where('price_categories.id', $cat->id)
                                                                            ->where('tickets.state', '<>', 'consumed')
                                                                            ->count();
            }

            $eventResults['total_visits'] = with(clone $viewQuery)->where('tickets.event_id', $event->id)->count();
            $eventResults['total_sum'] = with(clone $viewQuery)->where('tickets.event_id', $event->id)->sum('price_categories.price');

            // Get the sales for each vendor
            foreach( $vendors as $vendor ) {
                $eventResults[$vendor->name . '_sum'] = with(clone $viewQuery)->where('tickets.event_id', $event->id)
                                                                            ->where('purchases.vendor_id', $vendor->id)
                                                                            ->sum('price_categories.price');
            }

            // if a box office purchase exists, write the result, else 0
            $eventResults['boxoffice'] = $event->boxoffice ? $eventResults->boxoffice->total() : 0;
            // Amount of money gained without people showing up
            $eventResults['no-shows_sum'] = with(clone $viewQuery)->where('tickets.event_id', $event->id)
                                                                ->where('tickets.state', '<>', 'consumed')
                                                                ->sum('price_categories.price');



            // add the results to the end of the 
            array_push($result, $eventResults);
        }
        return $result;
    }
}
