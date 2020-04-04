<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        /**
         * Create the two online payment provider.
         * This is required to later link purchases to resellers.
         */

        $paypal = App\User::firstOrNew(['email' => 'paypal@system.local'], [
            'name' => 'PayPal',
            'email_verified_at' => null,
            // If password contains no value, it is impossible to login as this user because a comparission with a password hash is impossible 
            'password' => '',
        ]);
        $paypal->save();

        $klarna = App\User::firstOrNew(['email' => 'klarna@system.local'], [
            'name' => 'Klarna',
            'email_verified_at' => null,
            'password' => '',
        ]);
        $klarna->save();

        $paymentProvider = App\Role::where('name', 'PaymentProvider')->first();

        $paypal->roles()->attach($paymentProvider);
        $klarna->roles()->attach($paymentProvider);
    }
}