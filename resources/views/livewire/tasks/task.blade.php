<?php

use App\Models\User;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;

new class extends Component
{
    public Task $task;

    public function completeTask():void
    {
        $this->task->complete();
    }

    public function deleteTask():void
    {
        $this->task->delete();

        $this->dispatch('task-deleted');
    }
}
?>

<li class="border {{$task->isCompleted() ? 'border-green-500' : ''}} rounded p-3 mt-5">
    <div class="flex justify-between items-center">
        <div>{{ $task->title }}</div>
        <x-priority-lable :priority="$task->priority"></x-priority-lable>
    </div>
    @if ($task->status)
        <div class="flex flex-row justify-end items-center mt-5">
            <p class="text-s">Status :</p>
            <div class="ml-2 px-3 py-1 bg-gray-500 rounded-full text-white text-xs">
                {{ $task->status->name }}
            </div>
        </div>
    @endif
    <p class="mt-5">
        {{ $task->description }}
    </p>
    <div class="flex justify-between items-center mt-5">
        <div>
            Due Date: {{ $task->due_at ? $task->due_at->format('d-m-Y') : 'Not set' }}
        </div>
        <div>
            @if(! $task->isCompleted())
                <x-primary-button wire:click.prevent="completeTask">
                    <svg class="w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                    </svg>
                </x-primary-button>
                <x-secondary-button>
                    <svg class="w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                    </svg>
                </x-secondary-button>
            @endif
            <x-danger-button wire:click.prevent="deleteTask" wire:confirm="Are you sure you want to delete this task?">
                <svg class="w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                </svg>
            </x-danger-button>
        </div>
    </div>
</li>
