<?php

namespace Database\Factories;

use App\Models\Author;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;

class AuthorFactory extends Factory
{
    protected $model = Author::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'dob' => now()->subYears(10)
        ];
    }
}


