<?php

namespace App\Listeners;

use App\Events\TaskCompleted;
use App\Mail\TaskCompletedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendTaskCompletedNotification implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(TaskCompleted $event): void
    {
        $task = $event->task;

        Mail::to($task->user->email)->send(new TaskCompletedNotification($task));
    }
}
