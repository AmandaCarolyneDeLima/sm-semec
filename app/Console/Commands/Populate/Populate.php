<?php

namespace App\Console\Commands\Populate;

use Illuminate\Console\Command;
use DB;

class Populate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'populate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Populate database';

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
        if (\App::environment('production')) {
            $this->info('This task can not be run in production because it will erase de database');
            return;
        }

        /* Need to be delete before edicts because of restrictions of relationships */
        DB::table('inscriptions')->delete();

        $this->call('populate:servants');
        $this->call('populate:edicts');
        $this->call('populate:units');
        $this->call('populate:removal_types');
    }
}
