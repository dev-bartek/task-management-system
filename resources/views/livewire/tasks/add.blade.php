<?php

use App\Models\User;
use App\Models\Task;
use App\Models\Status;
use App\Enums\TaskPriority;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;

new class extends Component
{
    public string $title = '';
    public ?string $description = null;
    public array $taskPriorityOptions;
    public string $priority;
    public $due_at = null;
    public $status;
    public $statusOptions;

    public function mount()
    {
        $this->taskPriorityOptions = array_combine(TaskPriority::values(), TaskPriority::names());
        $this->statusOptions = Status::all()->pluck('name')->toArray();
    }

    public function addTask()
    {
        $user = Auth::user();
        $this->authorize('create', Task::class);

        $validated = $this->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['string', 'max:1000', 'nullable'],
            'priority' => [Rule::enum(TaskPriority::class)],
            'due_at' => ['date', 'nullable'],
            'status' => [Rule::exists('statuses', 'id'), 'nullable'],
        ]);

        $task = (new Task)->fill($validated);
        $task->user()->associate($user);
        $task->save();

        $this->dispatch('task-created');
        $this->dispatch('close-modal', 'add-task');
    }
}
?>

<div>
    <button class="p-2 border rounded border-black p"
            x-data=""
            x-on:click.prevent="$dispatch('open-modal', 'add-task')">
        {{ __('Add Task') }}
    </button>
    <x-modal name="add-task" :show="$errors->isNotEmpty()" focusable>
        <form wire:submit="addTask" class="p-6">
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
                    placeholder="{{ __('Task due at') }}"
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

                <x-input-error :messages="$errors->get('priority')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>
                <x-primary-button class="ms-3">
                    {{ __('Add Task') }}
                </x-primary-button>
            </div>
        </form>
    </x-modal>
</div>
