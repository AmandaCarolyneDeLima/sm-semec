<?php

namespace Database\Factories;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\Dependent;
use App\Models\Servant;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

class DependentFactory extends Factory
{

    /**
    * The name of the factory's corresponding model.
    *
    * @var string
    */
    protected $model = Dependent::class;

    /**
    * Define the model's default state.
    *
    * @return array
    */

    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'birthed_at' => $this->faker->date(),
            'degree' => $this->faker->text(),
            'study' => $this->faker->text(),
            'works' => $this->faker->text(),
            'servant_id' => Servant::factory(),
        ];
    }
}
