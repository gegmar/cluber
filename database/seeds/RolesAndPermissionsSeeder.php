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
        $pem_paymentProvider = App\Permission::create(['name' => 'PAYMENT_PROVIDER']);  // Allowed to perform online payments
        $pem_sellTickets = App\Permission::create(['name' => 'SELL_TICKETS']);          // Allowed to sell tickets
        $pem_reserveTickets = App\Permission::create(['name' => 'RESERVE_TICKETS']);    // Allowed to reserve tickets (currently not implemented)
        $pem_getNewsletter = App\Permission::create(['name' => 'RECEIVE_NEWSLETTER']);  // Wants to receive newsletters
        $pem_administrate = App\Permission::create(['name' => 'ADMINISTRATE']);         // Can administrate application
        $pem_supervise = App\Permission::create(['name' => 'SUPERVISE']);             // Can view all details of events, evaluate statistics

        $role_retailer = App\Role::create(['name' => 'Retailer']);
        $role_admin = App\Role::create(['name' => 'Administrator']);
        $role_newsletterReceiver = App\Role::create(['name' => 'NewsletterReceiver']);
        $role_paymentProvider = App\Role::create(['name' => 'PaymentProvider']);
        $role_supervisor = App\Role::create(['name' => 'Supervisor']);

        $role_newsletterReceiver->permissions()->attach($pem_getNewsletter);
        $role_paymentProvider->permissions()->attach($pem_paymentProvider);
        $role_admin->permissions()->attach($pem_administrate);
        $role_retailer->permissions()->attach($pem_sellTickets);
        $role_supervisor->permissions()->attach($pem_supervise);
    }
}
