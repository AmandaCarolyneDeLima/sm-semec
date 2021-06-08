<?php

namespace Database\Factories;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\Act;
use App\Models\Contract;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

class ActFactory extends Factory
{

    /**
    * The name of the factory's corresponding model.
    *
    * @var string
    */
    protected $model = Act::class;

    /**
    * Define the model's default state.
    *
    * @return array
    */

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'started_at' => $this->faker->date(),
            'ended_at' => $this->faker->date(),
            'number' => $this->faker->randomNumber(),
            'time' => $this->faker->randomNumber(),
            'number' => $this->faker->randomNumber(),
            'contract_id' => Contract::factory(),
        ];
    }
}
