<?php

namespace App\Console\Commands\Populate;

use Illuminate\Console\Command;
use DB;
use App\Models\Servant;
use App\Models\Contract;
use App\Models\Act;
use App\Models\License;
use App\Models\Dependent;

class Servants extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'populate:servants
                            {--json} populate from a json file locate at database/data/servants.json
                            {--clear} erase servants and relationships';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Populate servants';

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
            DB::table('servants')->delete();
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

        $this->info('Populate servants');
        DB::table('servants')->delete();
        $servants = Servant::factory()->count(30)->create();

        $servants->each(function ($servant) {
            $contracts = Contract::factory()->count(2)->create(['servant_id' => $servant->id]);
            $contracts->each(function ($contract) {
                Act::factory()->count(2)->create(['contract_id' => $contract->id]);
                License::factory()->count(2)->create(['contract_id' => $contract->id]);
            });

            Dependent::factory()->count(2)->create(['servant_id' => $servant->id]);
        });
    }

    private function populateFromJSON(): void
    {
        $jsonPath = base_path('./database/data/servants.json');
        $jsonString = file_get_contents($jsonPath);

        if ($jsonString === false) {
            $this->info('File servants.json not found');
            $this->info('You need to create servants.json file in database/data folder');
            return;
        }

        $servants = json_decode($jsonString);

        foreach ($servants as $cpf => $data) {
            $servant = $this->createOrUpdateServant($cpf, $data);

            foreach ($data->contracts as $contract) {
                $contractSaved = $this->createOrUpdateContract($servant, $contract);
                $this->createOrUpdateActs($contractSaved, $contract->acts);
            }

            $this->createOrUpdateDependents($servant, $data->dependents);
            $this->createOrUpdateLicenses($servant, $data->licenses);
        }
    }

    /**
     * Create or update Servant
     *
     * @param  string $cpf
     * @param  object $data
     */
    private function createOrUpdateServant($cpf, $data): Servant
    {
        return Servant::updateOrCreate(
            [
                'CPF' => $cpf
            ],
            [
                'name' => $data->name,
                'birthed_at' => $this->dateFormatter($data->birthed_at),
                'natural_from' => $data->natural_from,
                'marital_status' => $data->marital_status,
                'mother_name' => $data->mother_name,
                'father_name' => $data->father_name,
                'RG' => $data->RG,
                'PIS' => $data->PIS,
                'CTPS' => $data->CTPS,
                'title' => $data->title,
                'address' => $data->address,
                'phone' => $data->phone,
                'email' => $data->email,
            ]
        );
    }

    /**
     * Create or update acts
     *
     * @param  Servant $servant
     * @param  Contract $contract
     */
    private function createOrUpdateContract($servant, $contract): Contract
    {
        return Contract::updateOrCreate(
            [
                'servant_id' => $servant->id,
                'registration' => $contract->registration,
            ],
            [
                'admission_at' => $this->dateFormatter($contract->admission_at),
                'termination_at' => $this->dateFormatter($contract->termination_at),
                'secretary' => $contract->secretary,
                'place' => $contract->place,
                'role' => $contract->role,
                'link' => $contract->link,
            ]
        );
    }

    /**
     * Create or update acts
     *
     * @param  Contract $contract
     * @param  array $acts
     */
    private function createOrUpdateActs($contract, $acts): void
    {
        $contract->acts()->delete();

        foreach ($acts as $act) {
            $contract->acts()->create(
                [
                    'name' => $act->name,
                    'started_at' => $this->dateFormatter($act->started_at),
                    'ended_at' => $this->dateFormatter($act->ended_at),
                    'number' => $act->number,
                    'time' => $act->time
                ]
            );
        }
    }

    /**
     * Create or update Dependents
     *
     * @param  Servant $servant
     * @param  array $dependents
     */
    private function createOrUpdateDependents($servant, $dependents): void
    {
        $servant->dependents()->delete();

        foreach ($dependents as $dependent) {
            $servant->dependents()->create(
                [
                    'name' => $dependent->name,
                    'birthed_at' => $this->dateFormatter($dependent->birthed_at),
                    'degree' => $dependent->degree,
                    'study' => $dependent->study,
                    'works' => $dependent->works,
                ]
            );
        }
    }

    /**
     * Create or update licenses
     *
     * @param  Servant $servant
     * @param  array $licenses
     */
    private function createOrUpdateLicenses($servant, $licenses): void
    {
        foreach ($servant->contracts as $contract) {
            $contract->licenses()->delete();
        }

        foreach ($licenses as $license) {
            $c = Contract::where('registration', $license->registration)->first();
            $c->licenses()->create(
                [
                    'started_at' => $this->dateFormatter($license->started_at),
                    'ended_at' => $this->dateFormatter($license->ended_at),
                    'license_type' => $license->license_type,
                    'days' => $license->days,
                ]
            );
        }
    }

    /**
     * @param string $date
     */
    private function dateFormatter($date): string
    {
         return date('Y-m-d H:i:s', (int) strtotime($date));
    }
}
