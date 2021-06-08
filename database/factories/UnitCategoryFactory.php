<?php

namespace Database\Factories;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\UnitCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

class UnitCategoryFactory extends Factory
{

    /**
    * The name of the factory's corresponding model.
    *
    * @var string
    */
    protected $model = UnitCategory::class;

    /**
    * Define the model's default state.
    *
    * @return array
    */

    public function definition()
    {
        return [
            'name' => $this->faker->unique()->name,
        ];
    }
}
