<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class StatusFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->sentence(2),
        ];
    }
}
