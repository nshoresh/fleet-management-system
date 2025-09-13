<div class="bg-white rounded-lg shadow-lg overflow-hidden">
    <!-- Header -->
    <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-medium text-gray-900 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-500 mr-2" viewBox="0 0 20 20"
                fill="currentColor">
                <path fill-rule="evenodd"
                    d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                    clip-rule="evenodd" />
            </svg>
            Reset Password
        </h3>
        <p class="mt-1 text-sm text-gray-500">Please enter a new password for this account.</p>
    </div>

    <!-- Content -->
    <div class="px-6 py-5">
        <div class="space-y-5">
            <!-- Password Field -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">New Password</label>
                <div class="mt-1 relative rounded-md shadow-sm">
                    <input type="password" id="password" wire:model="password"
                        class="block w-full pr-10 border-gray-300 focus:ring-yellow-500 focus:border-yellow-500 rounded-md sm:text-sm"
                        placeholder="Enter new password">
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
                @error('password')
                    <span class="text-red-600 text-xs mt-1">{{ $message }}</span>
                @enderror
                <p class="mt-1 text-xs text-gray-500">Password must be at least 8 characters</p>
            </div>

            <!-- Confirm Password Field -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm
                    Password</label>
                <div class="mt-1 relative rounded-md shadow-sm">
                    <input type="password" id="password_confirmation" wire:model="password_confirmation"
                        class="block w-full pr-10 border-gray-300 focus:ring-yellow-500 focus:border-yellow-500 rounded-md sm:text-sm"
                        placeholder="Confirm new password">
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
                @error('password_confirmation')
                    <span class="text-red-600 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="bg-gray-50 px-6 py-4 flex justify-between items-center border-t border-gray-200">

        <button type="button" wire:click="resetPassword"
            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z"
                    clip-rule="evenodd" />
            </svg>
            Reset Password
        </button>
    </div>
</div>
