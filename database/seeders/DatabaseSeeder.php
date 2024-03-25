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
        $admin = User::factory()
            ->create([
                'name' => 'Admin User',
                'email' => 'admin@task-management-system.test',
                'type' => UserType::Admin->value,
            ]);

        Task::factory()
            ->count(3)
            ->for($admin)
            ->create([
                'status_id' => Status::factory()->create()->getKey(),
            ]);
    }
}
