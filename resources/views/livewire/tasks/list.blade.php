<?php

use App\Models\User;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;
use Livewire\WithPagination;

new class extends Component
{
    use WithPagination;

    protected $listeners = [
        'task-created' => '$refresh',
        'task-completed' => '$refresh',
        'task-updated' => '$refresh',
        'task-deleted' => '$refresh',
    ];

    public function with(): array
    {
        $user = Auth::user();

        $tasks = Task::where('user_id', $user->getKey())
            ->orderBy('created_at', 'desc')
            ->whereNull('completed_at');

        $tasksDone = Task::where('user_id', $user->getKey())
            ->orderBy('created_at', 'desc')
            ->whereNotNull('completed_at');

        if ($tasks->count() <= 10) {
            $this->resetPage();
        }

        return [
            'tasks' => $tasks->paginate(10),
            'tasksDone' => $tasksDone->paginate(10),
        ];
    }
}
?>


<div>
    <div class="p-5">
        <livewire:tasks.add/>
        <ul>
            @foreach($tasks as $task)
{{--                <livewire:tasks.task :task="$task" :key="$task->getKey()" wire:ignore/>--}}
                <livewire:tasks.task :task="$task"/>
            @endforeach
        </ul>
        @if($tasksDone->total())
        <h2 class="font-semibold text-xl text-gray-800 leading-tight mt-10">
            {{ __('Tasks Completed') }}
        </h2>
        <hr>
        @endif
        <ul>
            @foreach($tasksDone as $taskDone)
                <livewire:tasks.task :task="$taskDone"/>
            @endforeach
        </ul>
    </div>
    @if($tasks->total() > 1)
        <div class="p-5 border-t">
            {{ $tasks->links() }}
        </div>
    @endif
</div>
