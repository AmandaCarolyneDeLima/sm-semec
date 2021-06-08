<?php

namespace Database\Factories;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\Removal;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

class RemovalFactory extends Factory
{

    /**
    * The name of the factory's corresponding model.
    *
    * @var string
    */
    protected $model = Removal::class;

    /**
    * Define the model's default state.
    *
    * @return array
    */

     public function definition()
    {
        return [
            'removal' => $this->faker->name(),
        ];
    }
}
