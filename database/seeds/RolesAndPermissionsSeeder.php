<?php

use Illuminate\Database\Seeder;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Create default roles and permissions required for the app to work
         */
        $pem_paymentProvider = App\Permission::create(['name' => 'PAYMENT_PROVIDER']);
        $pem_sellTickets = App\Permission::create(['name' => 'SELL_TICKETS']);
        $pem_reserveTickets = App\Permission::create(['name' => 'RESERVE_TICKETS']);

        $role_reseller = App\Role::create(['name' => 'Reseller']);
        $role_admin = App\Role::create(['name' => 'Administrator']);
    }
}