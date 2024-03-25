@props(['priority'])

@php
    $color = [
        'low' => 'bg-green-500',
        'medium' => 'bg-orange-500',
        'high' => 'bg-red-500',
    ][$priority->value];
@endphp

<div class="flex flex-row items-center">
    <p class="text-s">Priority :</p>
    <div class="ml-2 px-3 py-1 {{ $color }} rounded-full text-white text-xs">
        {{ $priority->name }}
    </div>
</div>
