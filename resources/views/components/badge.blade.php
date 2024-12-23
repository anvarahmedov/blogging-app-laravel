@props(['textColor', 'bgColor'])

@php
    $textColor = match($textColor) {
        'gray' => 'text-gray-800',
        'red' => 'text-red-800',
        'blue' => 'text-blue-800',
        'yellow' => 'text-yellow-800',
        'white' => 'text-yellow-800',
        'purple' => 'text-purple-800',
        default => 'text-purple-800'
    };

    $bgColor = match($bgColor) {
        'gray' => 'bg-gray-100',
        'red' => 'bg-red-100',
        'blue' => 'bg-blue-100',
        'yellow' => 'bg-yellow-100',
        'white' => 'bg-white-100',
        'purple' => 'bg-purple-100',
        default => 'bg-purple-100'
    };
@endphp

<button {{ $attributes }} class = "{{ $textColor }} {{ $bgColor }} rounded-xl px-3 py-1 text-base">
    {{ $slot }} </button>
