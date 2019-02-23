<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use App\Role;

class AttachRoleToUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:attach-role {email} {role_name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Attaches the given role to the given user';

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
        $user = User::where('email', $this->argument('email'))->first();
        $role = Role::where('name', $this->argument('role_name'))->first();
        $user->roles()->attach($role);
        $this->line('Attached role #' . $role->id . ' to user #' . $user->id);
    }
}
