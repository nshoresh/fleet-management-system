<div>
    <x-app-layout>
        <x-slot name="header">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Client Dashboard') }}
            </h2>
        </x-slot>

        <div class="py-8">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

                    <!-- Vehicles -->
                    <div class="bg-white shadow rounded-2xl p-6">
                        <h3 class="text-sm font-medium text-gray-500">My Vehicles</h3>
                        <p class="mt-2 text-3xl font-bold text-gray-900">{{ $totalVehicles }}</p>
                    </div>

                    <!-- Active Licenses -->
                    <div class="bg-white shadow rounded-2xl p-6">
                        <h3 class="text-sm font-medium text-gray-500">Active Licenses</h3>
                        <p class="mt-2 text-3xl font-bold text-green-600">{{ $activeLicenses }}</p>
                    </div>

                    <!-- Users -->
                    <div class="bg-white shadow rounded-2xl p-6">
                        <h3 class="text-sm font-medium text-gray-500">Users</h3>
                        <p class="mt-2 text-3xl font-bold text-indigo-600">{{ $totalUsers }}</p>
                    </div>

                    <!-- Pending Approvals -->
                    <div class="bg-white shadow rounded-2xl p-6">
                        <h3 class="text-sm font-medium text-gray-500">Pending Approvals</h3>
                        <p class="mt-2 text-3xl font-bold text-yellow-500">{{ $pendingApprovals }}</p>
                    </div>
                </div>

                <!-- Overview / Recent Section -->
                <div class="mt-8 bg-white p-6 rounded-2xl shadow">
                    <h3 class="text-lg font-semibold text-gray-700">Overview</h3>
                    <p class="text-sm text-gray-500 mt-2">
                        Here's a quick summary of your recent activity.
                    </p>

                    <div class="mt-4">
                        <ul class="divide-y divide-gray-200">
                            <li class="py-3 text-sm text-gray-700">
                                🚗 Latest Vehicle Added: 
                                <strong>{{ $latestVehicle->license_plate ?? 'N/A' }}</strong>
                            </li>
                            <li class="py-3 text-sm text-gray-700">
                                📄 Latest License Status: 
                                <strong>{{ $latestLicense->license_status ?? 'N/A' }}</strong>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>
</div>
