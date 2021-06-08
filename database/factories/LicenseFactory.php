<?php

namespace Database\Factories;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\License;
use App\Models\Contract;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

class LicenseFactory extends Factory
{

    /**
    * The name of the factory's corresponding model.
    *
    * @var string
    */
    protected $model = License::class;

    /**
    * Define the model's default state.
    *
    * @return array
    */

    public function definition()
    {
        return [
            'started_at' => $this->faker->date(),
            'ended_at' => $this->faker->date(),
            'license_type' => $this->faker->text(),
            'days' => $this->faker->randomNumber(),
            'contract_id' => Contract::factory(),
        ];
    }
}
