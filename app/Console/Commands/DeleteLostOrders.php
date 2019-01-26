<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Purchase;

class DeleteLostOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:deleteLostOrders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Removes all Orders that are not paid and older than 15 minutes.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $lostOrders = Purchase::where('state', 'in_payment')
            ->whereRaw('state_updated < DATE_SUB(NOW(),INTERVAL 15 MINUTE)')
            ->get();

        foreach ($lostOrders as $purchase) {
            $id = $purchase->id;
            Log::info('Deleting purchase #' . $id . '...');
            $purchase->tickets->each(function ($ticket) {
                $ticket->delete();
            });
            $customer = $purchase->customer;
            $purchase->delete();
            if ($customer != null && $customer->password == '' && $customer->purchases->count() == 0) {
                Log::info('Deleting customer #' . $customer->id . ' of purchase #' . $id);
                $customer->delete();
            }
        }
    }
}
