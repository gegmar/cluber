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
        $pem_paymentProvider = App\Permission::firstOrCreate(['name' => 'PAYMENT_PROVIDER']);          // Allowed to perform online payments
        $pem_sellTickets = App\Permission::firstOrCreate(['name' => 'SELL_TICKETS']);                  // Allowed to sell tickets
        $pem_reserveTickets = App\Permission::firstOrCreate(['name' => 'RESERVE_TICKETS']);            // Allowed to reserve tickets
        $pem_handoutFreeTickets = App\Permission::firstOrCreate(['name' => 'HANDLING_FREE_TICKETS']);  // Allow to hand out free tickets
        $pem_getNewsletter = App\Permission::firstOrCreate(['name' => 'RECEIVE_NEWSLETTER']);          // Wants to receive newsletters
        $pem_administrate = App\Permission::firstOrCreate(['name' => 'ADMINISTRATE']);                 // Can administrate application
        $pem_supervise = App\Permission::firstOrCreate(['name' => 'SUPERVISE']);                       // Can view all details of events, evaluate statistics

        $role_retailer = App\Role::firstOrCreate(['name' => 'Retailer']);
        $role_reservation = App\Role::firstOrCreate(['name' => 'Reservation']);
        $role_freeTicketHandler = App\Role::firstOrCreate(['name' => 'FreeTicketHandler']);
        $role_supervisor = App\Role::firstOrCreate(['name' => 'Supervisor']);
        $role_admin = App\Role::firstOrCreate(['name' => 'Administrator']);
        $role_newsletterReceiver = App\Role::firstOrCreate(['name' => 'NewsletterReceiver']);
        $role_paymentProvider = App\Role::firstOrCreate(['name' => 'PaymentProvider']);

        $role_newsletterReceiver->permissions()->attach($pem_getNewsletter);
        $role_paymentProvider->permissions()->attach($pem_paymentProvider);
        $role_admin->permissions()->attach($pem_administrate);
        $role_retailer->permissions()->attach($pem_sellTickets);
        $role_reservation->permissions()->attach($pem_reserveTickets);
        $role_supervisor->permissions()->attach($pem_supervise);
        $role_freeTicketHandler->permissions()->attach($pem_handoutFreeTickets);
    }
}
