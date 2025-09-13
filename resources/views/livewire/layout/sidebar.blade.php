<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'HVMIS') }}</title>
    <style>
        /* Basic layout structure */
        .wrapper {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 250px; /*250px -> 450px*/
            /* Adjust width as needed */
            background-color: #f8f9fa;
            /* Customize color */
            border-right: 1px solid #dee2e6;
            /* Optional border */
        }

        .main-content {
            flex-grow: 1;
            padding: 20px;
        }

        /* Responsive layout */
        @media (max-width: 768px) {
            .wrapper {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                border-right: none;
                border-bottom: 1px solid #dee2e6;
            }
        }
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body>
    <div class="wrapper">
        <div class="sidebar">
            @if (auth()->user()->isAdmin() || auth()->user()->isSystemUser())
                @include('components.sidebar-test')
            @else
                @include('components.layouts.client-sidebar')
            @endif
        </div>

        <div class="main-content">
            @if (auth()->user()->isSystemUser())
                <!-- System user specific content here -->
            @endif

            @if (isset($header))
                <header>
                    {{ $header }}
                </header>
            @endif

            <main>
                {{ $slot }}
            </main>
        </div>
    </div>

    @livewireScripts
</body>

</html>
