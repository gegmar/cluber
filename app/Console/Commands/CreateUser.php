<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use Illuminate\Support\Facades\Hash;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-user {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a user with the given email as email address and username. Password will be generated and printed on commandline.';

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
        $user = new User();
        $user->email = $this->argument('email');
        $user->name = $this->argument('email');
        $user->email_verified_at = new \DateTime();
        $password = str_random(20);
        $user->password = Hash::make($password);
        $user->save();
        $this->info('Your password: ' . $password);
    }
}
