<?php

namespace Database\Factories;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\Contract;
use App\Models\Servant;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

class ContractFactory extends Factory
{

    /**
    * The name of the factory's corresponding model.
    *
    * @var string
    */
    protected $model = Contract::class;

    /**
    * Define the model's default state.
    *
    * @return array
    */

    public function definition()
    {
        return [
            'registration' => $this->faker->unique()->randomNumber,
            'admission_at' => $this->faker->date(),
            'termination_at' => $this->faker->date(),
            'secretary' => $this->faker->name(15),
            'place' => $this->faker->name(10),
            'role' => $this->faker->name(10),
            'link' => $this->faker->name(10),
            'servant_id' => Servant::factory(),
        ];
    }
}
