@props(['route', 'active' => null, 'indent' => 3])

@php
    $isActive = $active ?? request()->routeIs($route);
    $indentClass = $indent ? 'ml-' . $indent * 2 : '';

    $classes = $isActive
        ? "block px-3 py-2 {$indentClass} font-bold text-yellow-700 bg-yellow-50 rounded-md hover:bg-yellow-50 hover:text-yellow-700 transition duration-150"
        : "block px-3 py-2 {$indentClass} text-gray-600 rounded-md hover:bg-yellow-50 hover:text-yellow-700 transition duration-150";
@endphp

<a href="{{ route($route) }}" wire:navigate {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
