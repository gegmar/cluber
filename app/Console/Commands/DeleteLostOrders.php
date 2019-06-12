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
            ->where('state_updated', '<', (new \DateTime())->sub(new \DateInterval('PT15M')))
            ->get();

        foreach ($lostOrders as $purchase) {
            $purchase->deleteWithAllData();
        }
    }
}
