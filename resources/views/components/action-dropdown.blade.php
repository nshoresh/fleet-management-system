{{-- resources/views/components/action-dropdown.blade.php --}}
@props([
    'align' => 'right',
    'width' => 'w-40',
])

<div {{ $attributes->merge(['class' => 'relative text-left']) }} x-data="{ open: false }">
    <div @click="open = !open">
        @if (isset($trigger))
            {{ $trigger }}
        @else
            <x-gold-button-sm class="text-indigo-600 hover:text-indigo-900">
                <x-icons.three-dots />
            </x-gold-button-sm>
        @endif
    </div>

    <div x-show="open" x-cloak @click.away="open = false"
        class="absolute {{ $align === 'right' ? 'right-0' : 'left-0' }} z-30 {{ $width }} bg-white border border-gray-300 divide-y divide-gray-200 rounded-md shadow-lg">
        {{ $slot }}
    </div>
</div>
