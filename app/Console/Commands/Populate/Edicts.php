<?php

namespace App\Console\Commands\Populate;

use Illuminate\Console\Command;
use DB;
use App\Models\Edict;
use App\Models\Pdf;

class Edicts extends Command
{
   /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'populate:edicts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Populate edicts';

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

        $this->info('Populate edicts');
        DB::table('edicts')->delete();

        $currentDay = now()->day;
        $currentMonth = now()->month;
        $currentYear = now()->year;

        $nextDay = now()->addDays()->day;

        for ($i = 0; $i < 5; $i++) {
            $year = $currentYear - $i;
            $startedAt = "{$currentDay}/{$currentMonth}/{$year} 00:00";
            $endedAt = "{$nextDay}/{$currentMonth}/{$year} 23:59";

            Edict::factory(rand(5, 10))
                ->create(['started_at' => $startedAt, 'ended_at' => $endedAt])
                ->each(function ($edict) {
                    $edict->pdfs()->save(Pdf::factory()->make());
                    $edict->pdfs()->save(Pdf::factory()->make());
                });
        }
    }
}
