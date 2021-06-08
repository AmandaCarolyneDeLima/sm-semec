<?php

namespace Database\Factories;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\RemovalType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

class RemovalTypeFactory extends Factory
{

    /**
    * The name of the factory's corresponding model.
    *
    * @var string
    */
    protected $model = RemovalType::class;

    /**
    * Define the model's default state.
    *
    * @return array
    */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->name(),
        ];
    }
}
