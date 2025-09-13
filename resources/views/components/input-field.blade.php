@props([
    'wireModel', // e.g. form.email
    'id' => null,
    'type' => 'text',
    'placeholder' => '',
    'icon' => null, // name of heroicon outline
])

@php($inputId = $id ?? Str::slug($wireModel))

<div>
    <x-input-label :for="$inputId" :value="$attributes->get('label') ?? ucfirst($inputId)" />
    <div class="relative mt-1">
        <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
            <x-icons.{{ $icon }} class="w-5 h-5 text-gray-400" />
        </span>

        <input wire:model="{{ $wireModel }}" id="{{ $inputId }}" type="{{ $type }}"
            placeholder="{{ $placeholder }}"
            {{ $attributes->merge([
                'class' => 'block w-full pl-10 pr-12 sm:text-sm border-gray-300 rounded-md
                                             focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600
                                             dark:text-gray-100 transition',
            ]) }} />

        {{ $slot }} {{-- for right‑hand adornments (show/hide button, etc.) --}}
    </div>

    <x-input-error :messages="$errors->get($wireModel)" class="mt-1" />
</div>
