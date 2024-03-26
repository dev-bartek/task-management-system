<?php

use App\Models\Task;
use App\Models\Status;
use App\Enums\TaskPriority;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class extends Component
{
    public Task $task;
    public string $title;
    public $description;
    public array $taskPriorityOptions;
    public string $priority;
    public $due_at;
    public $status;
    public array $statusOptions;

    public function mount(Task $task): void
    {
        $this->task = $task;
        $this->title = $task->title;
        $this->description = $task->description;
        $this->due_at = $task->due_at->format('Y-m-d');
        $this->priority = $task->priority->value;

        $this->taskPriorityOptions = array_combine(TaskPriority::values(), TaskPriority::names());
        $this->statusOptions = Status::all()->pluck('name', 'id')->toArray();
    }

    public function updateTask(): void
    {
        $this->authorize('update', [Auth::user(), Task::class]);

        $this->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['string', 'max:1000', 'nullable'],
            'priority' => [Rule::enum(TaskPriority::class)],
            'due_at' => ['date', 'nullable'],
            'status' => [Rule::exists('statuses', 'id'), 'nullable'],
        ]);

        $this->task->update([
            'title' => $this->title,
            'description' => $this->description,
            'due_at' => $this->due_at,
            'priority' => $this->priority,
        ]);

        if (! is_null($this->status)) {
            $status = Status::findOrFail($this->status);
            $this->task->status()->associate($status);
        }

        $this->dispatch('task-updated');
        $this->dispatch('close-modal', 'update-task');
    }
}
?>

<div>
    <x-modal name="update-task" :show="$errors->isNotEmpty()" focusable>
        <form wire:submit="updateTask" class="p-6">
            <div>
                <x-input-label for="title" value="{{ __('Title') }}" />

                <x-text-input
                    wire:model="title"
                    id="title"
                    name="title"
                    type="text"
                    class="mt-1 block w-full"
                    placeholder="{{ __('Task title') }}"
                />

                <x-input-error :messages="$errors->get('title')" class="mt-2" />
            </div>
            <div class="mt-3">
                <x-input-label for="description" value="{{ __('Description') }}" />

                <x-textarea-input
                    wire:model="description"
                    id="description"
                    name="description"
                    type="text-area"
                    class="mt-1 block w-full"
                    placeholder="{{ __('Task description') }}"
                />

                <x-input-error :messages="$errors->get('description')" class="mt-2" />
            </div>
            <div class="mt-3">
                <x-input-label for="due_at" value="{{ __('Due date') }}"/>

                <x-text-input
                    wire:model="due_at"
                    id="due_at"
                    name="due_at"
                    type="date"
                    class="mt-1 block w-full"
                />

                <x-input-error :messages="$errors->get('due_at')" class="mt-2" />
            </div>
            <div class="mt-3">
                <x-input-label for="priority" value="{{ __('Task Priority') }}" />

                <x-select-input
                    wire:model="priority"
                    id="priority"
                    name="priority"
                    class="mt-1 block w-full"
                    placeholder="{{ __('Select Task Priority') }}"
                    :elementOptions="$taskPriorityOptions"
                />

                <x-input-error :messages="$errors->get('priority')" class="mt-2" />
            </div>

            <div class="mt-3">
                <x-input-label for="status" value="{{ __('Set Status') }}" />

                <x-select-input
                    wire:model="status"
                    id="status"
                    name="status"
                    class="mt-1 block w-full"
                    placeholder="{{ __('Set Task Status') }}"
                    :elementOptions="$statusOptions"
                />

                <x-input-error :messages="$errors->get('status')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>
                <x-primary-button class="ms-3">
                    {{ __('Update Task') }}
                </x-primary-button>
            </div>
        </form>
    </x-modal>
</div>
