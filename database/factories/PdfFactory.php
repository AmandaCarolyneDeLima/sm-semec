<?php

namespace Database\Factories;

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Pdf;
use App\Models\Edict;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;
use Illuminate\Http\UploadedFile;

class PdfFactory extends Factory
{

    /**
    * The name of the factory's corresponding model.
    *
    * @var string
    */
    protected $model = Pdf::class;

    /**
    * Define the model's default state.
    *
    * @return array
    */

    public function definition()
    {
        return [
            'pdf' =>  UploadedFile::fake()->create('document.pdf', 'application/pdf'),
            'name' => $this->faker->name(),
            'edict_id' => Edict::factory(),
        ];
    }
}
