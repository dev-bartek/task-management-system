<?php

use App\Enums\TaskPriority;
use App\Events\TaskCompleted;
use App\Listeners\SendTaskCompletedNotification;
use App\Mail\TaskCompletedNotification;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use Livewire\Volt\Volt;

test('task page is displayed', function () {
    $user = User::factory()->create();

    Task::factory()->for($user)->create();

    $this->actingAs($user);

    $response = $this->get('/tasks');

    $response->assertOk()
        ->assertSeeVolt('tasks.list')
        ->assertSeeVolt('tasks.add')
        ->assertSeeVolt('tasks.task')
        ->assertSeeVolt('tasks.update');
});

test('task can be created', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    $response = $this->get('/tasks');

    expect(Task::all())->toBeEmpty();

    $response->assertOk()
        ->assertSeeVolt('tasks.list')
        ->assertSeeVolt('tasks.add')
        ->assertDontSeeVolt('tasks.task');

    $title = 'New Task';

    $component = Volt::test('tasks.add')
        ->set('title', $title)
        ->set('priority', TaskPriority::High->value)
        ->call('addTask');

    $component
        ->assertHasNoErrors()
        ->assertNoRedirect();

    expect(Task::first())
        ->count()
        ->toBe(1)
        ->and(Task::first()->title)
        ->toEqual($title);
});

test('task can be updated', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    $oldTitle = 'OldTitle';

    $task = Task::factory()->for($user)->create([
        'title' => $oldTitle,
    ]);

    $response = $this->get('/tasks');

    $response->assertOk()
        ->assertSeeVolt('tasks.list')
        ->assertSeeVolt('tasks.add')
        ->assertSeeVolt('tasks.task')
        ->assertSeeVolt('tasks.update');

    $newTitle = 'New Title';

    $component = Volt::test('tasks.update', ['task' => $task])
        ->set('title', $newTitle)
        ->call('updateTask');

    $component
        ->assertHasNoErrors()
        ->assertNoRedirect();

    expect(Task::first()->title)
        ->toEqual($newTitle);
});

test('task can be deleted', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    $task = Task::factory()->for($user)->create();

    $response = $this->get('/tasks');

    $response->assertOk()
        ->assertSeeVolt('tasks.list')
        ->assertSeeVolt('tasks.add')
        ->assertSeeVolt('tasks.task')
        ->assertSeeVolt('tasks.update');

    $component = Volt::test('tasks.task', ['task' => $task])
        ->call('deleteTask');

    $component
        ->assertHasNoErrors()
        ->assertNoRedirect();

    expect(Task::all())
        ->toBeEmpty();
});

test('task can be completed', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    $task = Task::factory()->for($user)->create();

    expect($task->isCompleted())->toBeFalse();

    $response = $this->get('/tasks');

    $response->assertOk()
        ->assertSeeVolt('tasks.list')
        ->assertSeeVolt('tasks.add')
        ->assertSeeVolt('tasks.task')
        ->assertSeeVolt('tasks.update');

    $component = Volt::test('tasks.task', ['task' => $task])
        ->call('completeTask');

    $component
        ->assertHasNoErrors()
        ->assertNoRedirect();

    expect(Task::first()->isCompleted())
        ->toBeTrue();
});

test('completed task will dispatch laravel event', function () {
    Event::fake();

    Event::assertListening(
        TaskCompleted::class,
        SendTaskCompletedNotification::class
    );

    $user = User::factory()->create();

    $this->actingAs($user);

    $task = Task::factory()->for($user)->create();

    expect($task->isCompleted())->toBeFalse();

    $response = $this->get('/tasks');

    $response->assertOk();

    Volt::test('tasks.task', ['task' => $task])
        ->call('completeTask');

    expect(Task::first()->isCompleted())->toBeTrue();

    Event::assertDispatched(TaskCompleted::class, function ($event) use ($task) {
        return $event->task->id === $task->id;
    });
});

test('Notification Mail is queued for sending when task is set as complete', function () {
    Mail::fake();

    $user = User::factory()->create();

    $this->actingAs($user);

    $task = Task::factory()->for($user)->create();

    $response = $this->get('/tasks');

    $response->assertOk();

    Mail::assertNothingQueued();

    Volt::test('tasks.task', ['task' => $task])
        ->call('completeTask');

    Mail::assertNothingSent();
    Mail::assertQueued(TaskCompletedNotification::class);
});
