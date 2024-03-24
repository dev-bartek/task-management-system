<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class StatusFactory extends Factory
{
    public function definition(): array
    {
        $statusName = fake()->sentence(2);

        return [
            'name' => $statusName,
            'slug' => Str::slug($statusName),
        ];
    }
}
