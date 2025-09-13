@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
    'class' =>
        'block w-full pl-10 border-gray-300 rounded-sm shadow-sm focus:border-yellow-500 focus:ring-yellow-500 sm:text-sm p-3',
]) !!}>
