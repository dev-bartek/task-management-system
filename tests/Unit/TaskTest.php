<?php

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;

uses(RefreshDatabase::class);

it('can set task as completed', function () {
    $task = Task::factory()->for(User::factory())->make();

    expect($task->completed_at)->toBeNull();

    $task->complete();

    expect($task->completed_at)->toBeInstanceOf(Carbon::class);
});

it('can check if task is completed by using method', function () {
    $task = Task::factory()->for(User::factory())->make();

    expect($task->isCompleted())->toBeFalse();

    $task->complete();

    expect($task->isCompleted())->toBeTrue();
});
