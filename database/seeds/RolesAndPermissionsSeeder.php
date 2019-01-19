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
        $pem_getNewsletter = App\Permission::create(['name' => 'RECEIVE_NEWSLETTER']);

        $role_reseller = App\Role::create(['name' => 'Reseller']);
        $role_admin = App\Role::create(['name' => 'Administrator']);
        $role_newsletterReceiver = App\Role::create(['name' => 'NewsletterReceiver']);
        $role_paymentProvider = App\Role::create(['name' => 'PaymentProvider']);

        $role_newsletterReceiver->permissions()->attach($pem_getNewsletter);
        $role_paymentProvider->permissions()->attach($pem_paymentProvider);
    }
}