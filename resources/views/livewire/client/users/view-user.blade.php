<div x-data="{ showResetPasswordModal: false }" class="py-12">
    <div class="mx-auto max-w-12xl sm:px-6 lg:px-8">
        <div class="overflow-hidden bg-white rounded-lg shadow-xl border border-gray-100">
            <!-- Header with gold accent bar -->
            <div class="h-1 bg-gradient-to-r from-yellow-500 to-yellow-600"></div>

            <div class="px-8 py-10">
                <div class="flex justify-between items-center mb-8 border-b border-gray-100 pb-4">
                    <h2 class="text-2xl font-bold text-gray-800">
                        User Details
                    </h2>
                    <div class="flex space-x-3">
                        <a href="{{ route('users.edit', $user->id) }}" wire:navigate
                            class="inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-700 focus:bg-yellow-700 active:bg-yellow-800 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <x-icons.pencil-square />
                            Edit
                        </a>
                        <button
                            class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <x-icons.trash-icon />
                            Delete
                        </button>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-8 md:grid-cols-2">
                    <!-- Basic info -->
                    <div class="bg-gray-50 p-6 rounded-lg border border-gray-100">
                        <h3 class="mb-4 text-lg font-medium text-gray-800 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-yellow-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Basic Information
                        </h3>
                        <ul class="space-y-3">
                            <li class="flex border-b border-gray-100 pb-2">
                                <span class="w-1/3 font-medium text-gray-600">Name:</span>
                                <span class="w-2/3 text-gray-800">{{ $user->name }}</span>
                            </li>
                            <li class="flex border-b border-gray-100 pb-2">
                                <span class="w-1/3 font-medium text-gray-600">Email:</span>
                                <a href="mailto:{{ $user->email }}"
                                    class="w-2/3 text-yellow-600 hover:text-yellow-800 hover:underline">{{ $user->email }}</a>
                            </li>
                            <li class="flex border-b border-gray-100 pb-2">
                                <span class="w-1/3 font-medium text-gray-600">Phone:</span>
                                <a href="tel:{{ $user->phone }}"
                                    class="w-2/3 text-yellow-600 hover:text-yellow-800 hover:underline">{{ $user->phone }}</a>
                            </li>
                            <li class="flex border-b border-gray-100 pb-2">
                                <span class="w-1/3 font-medium text-gray-600">Role:</span>
                                <span class="w-2/3 text-gray-800">{{ optional($user->role)->name }}</span>
                            </li>
                            <li class="flex border-b border-gray-100 pb-2">
                                <span class="w-1/3 font-medium text-gray-600">Type:</span>
                                <span class="w-2/3 text-gray-800">{{ optional($user->user_type)->type_name }}</span>
                            </li>
                            <li class="flex">
                                <span class="w-1/3 font-medium text-gray-600">Status:</span>
                                <span class="w-2/3">
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        {{ optional($user->account_status)->status }}
                                    </span>
                                </span>
                            </li>
                        </ul>
                    </div>

                    <!-- Timestamps and Actions -->
                    <div class="bg-gray-50 p-6 rounded-lg border border-gray-100">
                        <h3 class="mb-4 text-lg font-medium text-gray-800 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-yellow-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Activity Timeline
                        </h3>
                        <ul class="space-y-3">
                            <li class="flex border-b border-gray-100 pb-2">
                                <span class="w-1/2 font-medium text-gray-600">Email verified:</span>
                                <span class="w-1/2 text-gray-800">
                                    {{ $user->email_verified_at?->format('d‑M‑Y H:i') ?? '—' }}
                                </span>
                            </li>
                            <li class="flex border-b border-gray-100 pb-2">
                                <span class="w-1/2 font-medium text-gray-600">Created:</span>
                                <span class="w-1/2 text-gray-800">
                                    {{ $user->created_at?->format('d‑M‑Y H:i') ?? 'N/A' }}
                                </span>
                            </li>
                            <li class="flex border-b border-gray-100 pb-2">
                                <span class="w-1/2 font-medium text-gray-600">Updated:</span>
                                <span class="w-1/2 text-gray-800">
                                    {{ $user->updated_at?->format('d‑M‑Y H:i') ?? 'N/A' }}
                                </span>
                            </li>
                        </ul>

                        <div class="mt-6 pt-4 border-t border-gray-100">
                            <h4 class="text-sm font-medium text-gray-600 mb-3">Quick Actions</h4>
                            <div class="flex flex-wrap gap-2">
                                <button type="button" @click="showResetPasswordModal = true"
                                    class="inline-flex items-center px-3 py-2 bg-yellow-100 text-yellow-800 text-xs font-medium rounded-md hover:bg-yellow-200 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                    Reset Password
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer with actions -->
            <div class="px-8 py-4 bg-gray-50 border-t border-gray-100 flex justify-end space-x-3">
                <a href="#" class="text-yellow-600 hover:text-yellow-800 font-medium text-sm">
                    View Activity Log
                </a>
                <span class="text-gray-300">|</span>
                <a href="#" class="text-yellow-600 hover:text-yellow-800 font-medium text-sm">
                    View Permissions
                </a>
            </div>
        </div>

        @if ($vehicleOwner)
            <div class="bg-white rounded-lg shadow-md p-4 mt-3">
                <div class="space-y-3">
                    <div class="flex items-center justify-between border-b border-gray-200 pb-3">
                        <h3 class="text-lg font-medium text-gray-900">Vehicle Owner Details</h3>
                        <div class="flex items-center space-x-2">
                            <span
                                class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 uppercase">{{ $vehicleOwner->status }}</span>
                            <a href="{{ route('admin.vehicle-owners.view', $vehicleOwner->id) }}" wire:navigate
                                class="inline-flex items-center px-3 py-1 border border-transparent text-xs font-medium rounded text-blue-700 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                View Details
                            </a>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Name</p>
                            <p class="mt-1 text-sm text-gray-900">{{ $vehicleOwner->name }}</p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-500">Contact Number</p>
                            <p class="mt-1 text-sm text-gray-900">{{ $vehicleOwner->contact_number }}</p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-500">Email</p>
                            <p class="mt-1 text-sm text-gray-900">{{ $vehicleOwner->email }}</p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-500">Owner Type</p>
                            <p class="mt-1 text-sm text-gray-900">
                                {{ $vehicleOwner->vehicle_owner_type_id == 1 ? 'Individual' : 'Company' }}</p>
                        </div>

                        <div class="md:col-span-2">
                            <p class="text-sm font-medium text-gray-500">Address</p>
                            <p class="mt-1 text-sm text-gray-900">{{ $vehicleOwner->address }}</p>
                        </div>

                        <div class="md:col-span-2 flex justify-end">
                            <a href="{{ route('admin.vehicle-owners.edit', $vehicleOwner->id) }}" wire:navigate
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                Edit Vehicle Owner
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif

    </div>


    <!-- Reset Password Modal - Controlled by JavaScript -->
    <div x-show="showResetPasswordModal" class="fixed inset-0 z-10" style="display: none;" x-cloak>
        <!-- Background overlay -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

        <!-- Modal panel -->
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div
                class="relative inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <!-- Header -->
                <div class="bg-yellow-50 px-4 py-3 sm:px-6 flex justify-between items-center">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Reset Password for {{ $user->name }}

                    </h3>
                    <button type="button" @click="showResetPasswordModal = false">
                        <x-icons.x-plain /> </button>

                </div>
                <livewire:admin.users.rest-password-modal id="{{ $user->id }}" />
            </div>
        </div>
    </div>
