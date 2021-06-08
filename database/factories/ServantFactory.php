<?php

namespace Database\Factories;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\Servant;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

class ServantFactory extends Factory
{

    /**
    * The name of the factory's corresponding model.
    *
    * @var string
    */
    protected $model = Servant::class;

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
            'natural_from' => $this->faker->text(),
            'marital_status' => $this->faker->text(),
            'mother_name' => $this->faker->name(),
            'father_name' => $this->faker->name(),
            'CPF' => $this->faker->randomNumber(),
            'RG' => $this->faker->randomNumber(),
            'PIS' => $this->faker->randomNumber(),
            'CTPS' => $this->faker->randomNumber(),
            'title' => $this->faker->text(),
            'address' => $this->faker->address(10),
            'phone' => $this->faker->randomNumber(),//$faker->tollFreePhoneNumber(),
            'email' => $this->faker->email(),
            'password' => 'password',//'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ];
    }
}
