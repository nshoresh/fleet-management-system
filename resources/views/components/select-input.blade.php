<!-- resources/views/components/select-input.blade.php -->
@props([
    'label' => '',
    'name',
    'id' => null,
    'model' => null,
    'options' => [],
    'placeholder' => 'Select an option',
    'required' => false,
    'debounce' => '300ms',
])

@php
    $wireModel = $model ? "wire:model.live.debounce.$debounce=$model" : '';
    $inputId = $id ?? $name;
@endphp

<div>
    @if ($label)
        <label for="{{ $inputId }}" class="block text-sm font-medium text-gray-700">
            {{ $label }}
            @if ($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    <select id="{{ $inputId }}" name="{{ $name }}" {{ $wireModel }} {{ $required ? 'required' : '' }}
        {{ $attributes->merge(['class' => 'block w-full mt-1 border-gray-300 rounded-sm shadow-sm focus:ring-yellow-500 focus:border-yellow-500 sm:text-sm']) }}>
        <option value="">{{ $placeholder }}</option>
        {{ $slot }}
    </select>

    @error($name)
        <span class="text-sm text-red-600">{{ $message }}</span>
    @enderror
</div>
