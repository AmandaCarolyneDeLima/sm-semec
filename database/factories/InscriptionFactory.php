<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\Inscription;
use App\Models\Servant;
use App\Models\Contrat;
use App\Models\RemovalType;
use App\Models\Unit;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/
$factory->define(Inscription::class, function (Faker $faker) {
    return [
        'servant_id' => Servant::factory(),
        'contract_id' => Contract::factory(),
        'removal_type_id' => RemovalType::factory(),
        'edict_id' => Edict::factory(),
        'current_unit_id' => Unit::factory(),
        'interested_unit_id' => Unit::factory(),
        'reason' => $faker->text(),
    ];
});
