<div class="bg-white rounded-3xl shadow-lg p-8">
    @if ($vehicleOwner)
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
            <h3 class="text-2xl font-bold text-gray-900">Vehicle Owner Profile</h3>
            <div class="flex items-center space-x-3 mt-4 md:mt-0">
                {{-- Verification Status --}}
                @if ($vehicleOwner->isVerified())
                    <span
                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                        Verified
                    </span>
                @else
                    <span
                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                clip-rule="evenodd" />
                        </svg>
                        Pending Verification
                    </span>
                @endif

                {{-- Active Status --}}
                @if ($vehicleOwner->isActive())
                    <span
                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                        Active
                    </span>
                @else
                    <span
                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                        Inactive
                    </span>
                @endif
            </div>
        </div>

        {{-- Show contact notice if not verified or not active --}}
        @if (!$vehicleOwner->isVerified() || !$vehicleOwner->isActive())
            <div class="mb-6 p-4 rounded-lg bg-yellow-50 border-l-4 border-yellow-400 flex items-start space-x-3">
                <svg class="w-6 h-6 text-yellow-500 mt-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                        clip-rule="evenodd" />
                </svg>
                <div>
                    <p class="font-semibold text-yellow-800">Your profile has not been fully verified and activated.</p>
                    <p class="text-yellow-700 text-sm">
                        For updates or enquiries, please contact the System Owners:<br>
                        <span class="font-medium">Email:</span> <a href="mailto:support@example.com"
                            class="underline text-blue-700">support@example.com</a><br>
                        <span class="font-medium">Phone:</span> <a href="tel:+1234567890"
                            class="underline text-blue-700">+1 234 567 890</a>
                    </p>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            {{-- Personal Information --}}
            <div>
                <h4 class="font-semibold text-gray-900 border-b pb-2 mb-4">Personal Information</h4>
                <dl class="space-y-3">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Name</dt>
                        <dd class="text-gray-900">{{ $vehicleOwner->name ?? 'N/A' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Email</dt>
                        <dd class="text-gray-900">{{ $vehicleOwner->email ?? 'N/A' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Contact Number</dt>
                        <dd class="text-gray-900">{{ $vehicleOwner->contact_number ?? 'N/A' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Address</dt>
                        <dd class="text-gray-900">{{ $vehicleOwner->address ?? 'N/A' }}</dd>
                    </div>
                    @if ($vehicleOwner->id_number)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">ID Number</dt>
                            <dd class="text-gray-900">{{ $vehicleOwner->id_number }}
                                ({{ $vehicleOwner->id_type ?? 'Unknown Type' }})</dd>
                        </div>
                    @endif
                </dl>
            </div>

            {{-- Business Information --}}
            @if ($vehicleOwner->business_name)
                <div>
                    <h4 class="font-semibold text-gray-900 border-b pb-2 mb-4">Business Information</h4>
                    <dl class="space-y-3">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Business Name</dt>
                            <dd class="text-gray-900">{{ $vehicleOwner->business_name }}</dd>
                        </div>
                        @if ($vehicleOwner->business_type)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Business Type</dt>
                                <dd class="text-gray-900">{{ $vehicleOwner->business_type }}</dd>
                            </div>
                        @endif
                        @if ($vehicleOwner->business_email)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Business Email</dt>
                                <dd class="text-gray-900">{{ $vehicleOwner->business_email }}</dd>
                            </div>
                        @endif
                        @if ($vehicleOwner->business_phone)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Business Phone</dt>
                                <dd class="text-gray-900">{{ $vehicleOwner->business_phone }}</dd>
                            </div>
                        @endif
                        @if ($vehicleOwner->business_address)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Business Address</dt>
                                <dd class="text-gray-900">{{ $vehicleOwner->business_address }}</dd>
                            </div>
                        @endif
                        @if ($vehicleOwner->business_registration_number)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Registration Number</dt>
                                <dd class="text-gray-900">{{ $vehicleOwner->business_registration_number }}</dd>
                            </div>
                        @endif
                        @if ($vehicleOwner->business_website)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Website</dt>
                                <dd>
                                    <a href="{{ $vehicleOwner->business_website }}" target="_blank"
                                        class="text-blue-600 hover:text-blue-800 underline">
                                        {{ $vehicleOwner->business_website }}
                                    </a>
                                </dd>
                            </div>
                        @endif
                    </dl>
                </div>
            @endif
        </div>

        {{-- Statistics --}}
        <div class="mt-8 grid grid-cols-1 sm:grid-cols-3 gap-6">
            <div class="bg-blue-100 rounded-lg p-5 text-center">
                <div class="text-3xl font-bold text-blue-700">{{ $vehicleOwner->vehicles_count }}</div>
                <div class="text-sm text-blue-700">Total Vehicles</div>
            </div>
            <div class="bg-green-100 rounded-lg p-5 text-center">
                <div class="text-3xl font-bold text-green-700">{{ $vehicleOwner->usercount }}</div>
                <div class="text-sm text-green-700">Associated Users</div>
            </div>
            <div class="bg-purple-100 rounded-lg p-5 text-center">
                <div class="text-3xl font-bold text-purple-700">{{ $vehicleOwner->fleets_count_formatted }}</div>
                <div class="text-sm text-purple-700">Fleet Size</div>
            </div>
        </div>

        {{-- Verification Status --}}
        <div class="mt-8 border-t pt-6">
            <h4 class="font-semibold text-gray-900 mb-4">Verification Status</h4>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div class="flex items-center space-x-3">
                    @if ($vehicleOwner->isVerified())
                        <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="text-green-700">Information Verified</span>
                    @else
                        <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="text-red-700">Information Pending</span>
                    @endif
                </div>
                <div class="flex items-center space-x-3">
                    @if ($vehicleOwner->isDocumentsVerified())
                        <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="text-green-700">Documents Verified</span>
                    @else
                        <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="text-red-700">Documents Pending</span>
                    @endif
                </div>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="mt-8 flex flex-wrap gap-4">
            <x-gold-button>
                Edit Profile
            </x-gold-button>
            @if (!$vehicleOwner->isVerified())
                <button
                    class="bg-green-700 hover:bg-green-800 text-white px-5 py-2 rounded-md text-sm font-semibold transition-colors">
                    Complete Verification
                </button>
            @endif
            <button
                class="bg-gray-700 hover:bg-gray-800 text-white px-5 py-2 rounded-md text-sm font-semibold transition-colors">
                View Full Details
            </button>
        </div>
    @else
        {{-- No Vehicle Owner Found --}}
        <div class="text-center py-12">
            <svg class="w-20 h-20 text-gray-400 mx-auto mb-5" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <h3 class="text-2xl font-bold text-gray-900 mb-3">No Vehicle Owner Profile Found</h3>
            <p class="text-gray-600 mb-6">You haven't set up your vehicle owner profile yet.</p>
            <button
                class="bg-blue-700 hover:bg-blue-800 text-white px-8 py-3 rounded-md font-semibold transition-colors">
                Create Vehicle Owner Profile
            </button>
        </div>
    @endif
</div>
