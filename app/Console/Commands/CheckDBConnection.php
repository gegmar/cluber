<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CheckDBConnection extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-db-connection';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks if the database is reachable and ready to receive queries.';

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
        try {
            DB::statement('show tables');
            $this->info('Database connection available!');
        } catch( \Illuminate\Database\QueryException $e) {
            $this->error('Database connection not available!');
            exit(1); // return a non-0-code to be used in shell scripts as a falsy exit state
        }
    }
}
