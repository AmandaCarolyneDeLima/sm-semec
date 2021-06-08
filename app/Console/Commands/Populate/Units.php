<?php

namespace App\Console\Commands\Populate;

use Illuminate\Console\Command;
use DB;
use App\Models\Unit;
use App\Models\UnitCategory;

class Units extends Command
{
   /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'populate:units
                           {--json} populate from a json file locate at database/data/units.json
                           {--clear} erase servants and relationships';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Populate Units';

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
            DB::table('units')->delete();
            DB::table('unit_categories')->delete();
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

        $this->info('Populate Units');
        DB::table('units')->delete();
        DB::table('unit_categories')->delete();

        $categories = UnitCategory::factory()->count(4)->create();

        $categories->each(function ($category) {
             Unit::factory()->count(22)->create(['category_id' => $category->id]);
        });
    }

    private function populateFromJSON(): void
    {
        $this->info('Populate Units from ./database/data/units.json');
        $jsonPath = base_path('./database/data/units.json');
        $jsonString = file_get_contents($jsonPath);

        if ($jsonString === false) {
            $this->info('File units.json not found');
            $this->info('You need to create units.json file in database/data folder');
            return;
        }

        $jsonDecoded = json_decode($jsonString);
        $unitsCategory = $jsonDecoded->units_categories;

        foreach ($unitsCategory as $data) {
            $category = $this->createOrUpdateUnitCategory($data);

            foreach ($data->units as $unit) {
                  $this->createOrUpdateUnit($category, $unit);
            }
        }
    }

        /**
     * Create or update UnitCategory
     *
     * @param  object $data
     */
    public function createOrUpdateUnitCategory($data): UnitCategory
    {
        return UnitCategory::updateOrCreate(
            [
                'name' => $data->name,
            ]
        );
    }

    /**
     * Create or update Unit
     *
     * @param  object $unit
     * @param  object $category
     */
    public function createOrUpdateUnit($category, $unit): Unit
    {
        return Unit::updateOrCreate(
            [
                'category_id' => $category->id,
                'name' => $unit->name,
            ],
            [
                'address' => $unit->address,
                'phone'  => $unit->phone,
            ]
        );
    }
}
