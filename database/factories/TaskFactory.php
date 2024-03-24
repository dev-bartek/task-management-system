<?php

namespace Database\Factories;

use App\Enums\TaskPriority;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3),
            'description' => fake()->paragraph(1),
            'due_at' => now()->addDays(rand(1, 5)),
            'priority' => fake()->randomElement(TaskPriority::values()),
        ];
    }

    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'completed_at' => now(),
        ]);
    }


}
