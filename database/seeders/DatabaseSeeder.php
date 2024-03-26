<?php

namespace Database\Seeders;

use App\Enums\UserType;
use App\Models\Status;
use App\Models\task;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $statuses = Status::factory()->createMany([
            ['name' => 'Pending'],
            ['name' => 'Require Research'],
            ['name' => 'Awaits information'],
        ]);

        $admin = User::factory()
            ->create([
                'name' => 'Admin User',
                'email' => 'admin@tms.test',
                'type' => UserType::Admin->value,
                //password is password
            ]);

        Task::factory()
            ->count(5)
            ->for($admin)
            ->sequence(
                ['status_id' => fake()->randomElement($statuses->pluck('id'))],
                ['status_id' => fake()->randomElement($statuses->pluck('id'))]
            )
            ->create();

        $user = User::factory()
            ->create([
                'name' => 'Normal User',
                'email' => 'user@tms.test',
                'type' => UserType::User->value,
            ]);

        Task::factory()
            ->count(5)
            ->for($user)
            ->sequence(
                ['status_id' => fake()->randomElement($statuses->pluck('id'))],
                ['status_id' => fake()->randomElement($statuses->pluck('id'))]
            )
            ->create();
    }
}
