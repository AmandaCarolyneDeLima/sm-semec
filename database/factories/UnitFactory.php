<?php

namespace Database\Factories;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\Unit;
use App\Models\UnitCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

class UnitFactory extends Factory
{

    /**
    * The name of the factory's corresponding model.
    *
    * @var string
    */
    protected $model = Unit::class;

    /**
    * Define the model's default state.
    *
    * @return array
    */

    public function definition()
    {
        return [
            'name' => $this->faker->unique()->name,
            'address' => $this->faker->unique()->streetaddress,
            'phone' => $this->faker->unique()->phoneNumber,
            'category_id' => UnitCategory::factory(),
        ];
    }
}
