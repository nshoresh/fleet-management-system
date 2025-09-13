<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>HVMIS</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>

    <div class="antialiased bg-gray-50 dark:bg-gray-900">
        <!-- Sidebar -->
        <x-top-bar />
        <x-side-menu-bar />

        <main class="h-auto p-4 pt-20 md:ml-64">
            <div class="grid grid-cols-1 gap-4 mb-4 sm:grid-cols-2 lg:grid-cols-4">
                <div class="h-32 border-2 border-gray-300 border-dashed rounded-lg dark:border-gray-600 md:h-64">
                </div>
                <div class="h-32 border-2 border-gray-300 border-dashed rounded-lg dark:border-gray-600 md:h-64">
                </div>
                <div class="h-32 border-2 border-gray-300 border-dashed rounded-lg dark:border-gray-600 md:h-64">
                </div>
                <div class="h-32 border-2 border-gray-300 border-dashed rounded-lg dark:border-gray-600 md:h-64">
                </div>
            </div>
            <div class="mb-4 border-2 border-gray-300 border-dashed rounded-lg dark:border-gray-600 h-96"></div>
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div class="h-48 border-2 border-gray-300 border-dashed rounded-lg dark:border-gray-600 md:h-72">
                </div>
                <div class="h-48 border-2 border-gray-300 border-dashed rounded-lg dark:border-gray-600 md:h-72">
                </div>
                <div class="h-48 border-2 border-gray-300 border-dashed rounded-lg dark:border-gray-600 md:h-72">
                </div>
                <div class="h-48 border-2 border-gray-300 border-dashed rounded-lg dark:border-gray-600 md:h-72">
                </div>
            </div>
            <div class="mb-4 border-2 border-gray-300 border-dashed rounded-lg dark:border-gray-600 h-96"></div>
            <div class="grid grid-cols-2 gap-4">
                <div class="h-48 border-2 border-gray-300 border-dashed rounded-lg dark:border-gray-600 md:h-72">
                </div>
                <div class="h-48 border-2 border-gray-300 border-dashed rounded-lg dark:border-gray-600 md:h-72">
                </div>
                <div class="h-48 border-2 border-gray-300 border-dashed rounded-lg dark:border-gray-600 md:h-72">
                </div>
                <div class="h-48 border-2 border-gray-300 border-dashed rounded-lg dark:border-gray-600 md:h-72">
                </div>
            </div>
        </main>
    </div>
</body>

</html>
