@props(['title' => __('Log in')])

<div
    {{ $attributes->merge(['class' => 'flex flex-col items-center min-h-screen bg-gray-50 dark:bg-gray-900 pt-10 sm:pt-0']) }}>
    <div
        class="w-full max-w-md px-8 py-10 transition-all duration-300 bg-white shadow-lg dark:bg-gray-800 rounded-xl ring-1 ring-gray-200 dark:ring-gray-700">
        <div class="flex justify-center mb-6">
            <x-business-logo class="w-auto h-12" />
        </div>

        <h1 class="mb-6 text-xl font-semibold text-center text-gray-700 dark:text-gray-200">
            {{ $title }}
        </h1>

        {{ $slot }}
    </div>
</div>
