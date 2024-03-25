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
        'task-deleted' => '$refresh',
    ];

    public function with(): array
    {
        $user = Auth::user();

        $tasks = Task::where('user_id', $user->getKey());

        if ($tasks->count() <= 10) {
            $this->resetPage();
        }

        return [
            'tasks' => $tasks->paginate(10),
        ];
    }
}
?>


<div>
    <div class="p-5">
        <livewire:tasks.add/>
        <ul>
            @foreach($tasks as $task)
                <livewire:tasks.task :task="$task" :key="$task->getKey()"/>
            @endforeach
        </ul>
    </div>
    <div class="p-5 border-t">
        {{ $tasks->links() }}
    </div>
</div>
