<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TaskPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    public function view(User $user, Task $task): bool
    {
        return $task->user->getKey() === $user->getKey();
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Task $task): bool
    {
        return $task->user->getKey() === $user->getKey();
    }

    public function delete(User $user, Task $task): bool
    {
        return $task->user->getKey() === $user->getKey();
    }

    public function restore(User $user, Task $task): bool
    {
        return $task->user->getKey() === $user->getKey();
    }

    public function forceDelete(User $user, Task $task): bool
    {
        return $task->user->getKey() === $user->getKey();
    }
}
