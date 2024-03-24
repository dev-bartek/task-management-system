<?php

use App\Models\Task;
use Illuminate\Support\Carbon;

it('can set task as completed', function () {
    $task = Task::factory()->make();

    expect($task->completed_at)->toBeNull();

    $task->complete();

    expect($task->completed_at)->toBeInstanceOf(Carbon::class);
});

it('can check if task is completed by using method', function () {
    $task = Task::factory()->make();

    expect($task->isCompleted())->toBeFalse();

    $task->complete();

    expect($task->isCompleted())->toBeTrue();
});
