<?php

namespace App\Console\Commands\Populate;

use Illuminate\Console\Command;
use DB;
use App\Models\RemovalType;

class RemovalTypes extends Command
{
   /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'populate:removal_types
                            {--json} populate from a json file locate at database/data/removal_types.json
                            {--clear} erase removal types and relationships';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Populate Removal Types';

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
        if ($this->option('clear')) {
            DB::table('removal_types')->delete();
        }

        if ($this->option('json')) {
            $this->populateFromJSON();
            return;
        }

        $this->populateFromFaker();
    }

    private function populateFromFaker(): void
    {
        if (\App::environment('production')) {
            $this->info('This task can not be run in production because it will erase de database');
            return;
        }

        $this->info('Populate Removal Types');
        DB::table('removal_types')->delete();

        RemovalType::factory()->count(3)->create();
    }

    private function populateFromJSON(): void
    {
        $this->info('Populate Removals from ./database/data/removal_types.json');
        $jsonPath = base_path('./database/data/removal_types.json');
        $jsonString = file_get_contents($jsonPath);

        if ($jsonString === false) {
            $this->info('File removal_types.json not found');
            $this->info('You need to create removal.json file in database/data folder');
            return;
        }

        $jsonDecoded = json_decode($jsonString);
        $removalTypes = $jsonDecoded->removal_types;

        foreach ($removalTypes as $data) {
            RemovalType::updateOrCreate([
              'name' => $data->name
            ]);
        }
    }
}
