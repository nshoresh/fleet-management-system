<div class="mx-auto max-w-12xl sm:px-6 lg:px-8">
    <div class="overflow-hidden bg-white rounded-lg ">
        <div class="p-2">
            <h1 class="text-xl font-semibold text-white">Vehicle Owner Details</h1>
            <div class="flex justify-between gap-2">
                <div class="justify-start">
                    <x-gold-button-link-sm href="{{ route('admin.vehicle-owners') }}" wire:navigate>
                        <x-icons.arrow-left />
                        Back
                    </x-gold-button-link-sm>
                </div>

            </div>
        </div>
        <!-- Content -->
        <div class="p-6">
            <div class="mb-8">
                <h2 class="pb-2 text-2xl font-bold text-gray-800 border-b border-gray-200">
                    {{ $vehicleOwner->business_name }}
                </h2>
            </div>
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <!-- Left Column -->
                <div class="space-y-6">
                    <div>
                        <h3 class="mb-2 text-sm font-medium text-gray-500">Owner Type</h3>
                        <p class="p-3 text-gray-700 rounded-md bg-gray-50">{{ $vehicleOwner->vehicle_owner_type->name }}
                        </p>
                    </div>
                    <div>
                        <h3 class="mb-2 text-sm font-medium text-gray-500">Contact Number</h3>
                        <p class="p-3 text-gray-700 rounded-md bg-gray-50">{{ $vehicleOwner->contact_number }}</p>
                    </div>
                    <div>
                        <h3 class="mb-2 text-sm font-medium text-gray-500">Email Address</h3>
                        <p class="p-3 text-gray-700 rounded-md bg-gray-50">{{ $vehicleOwner->email }}</p>
                    </div>
                </div>
                <!-- Right Column -->
                <div class="space-y-6">
                    <div>
                        <h3 class="mb-2 text-sm font-medium text-gray-500">Address</h3>
                        <p class="p-3 text-gray-700 rounded-md bg-gray-50">{{ $vehicleOwner->address }}</p>
                    </div>
                    <div>
                        <h3 class="mb-2 text-sm font-medium text-gray-500">Registration Number</h3>
                        <p class="p-3 text-gray-700 rounded-md bg-gray-50">
                            {{ $vehicleOwner->business_registration_number }}</p>
                    </div>
                    <div>
                        <h3 class="mb-2 text-sm font-medium text-gray-500">Registration Date</h3>
                        <p class="p-3 text-gray-700 rounded-md bg-gray-50">
                            {{ $vehicleOwner->created_at->format('F d, Y') }}</p>
                    </div>
                    <div>
                        <h3 class="mb-2 text-sm font-medium text-gray-500">Last Updated</h3>
                        <p class="p-3 text-gray-700 rounded-md bg-gray-50">
                            {{ $vehicleOwner->updated_at->format('F d, Y h:i A') }}</p>
                    </div>
                </div>
            </div>
            <div class="mb-4">
                @if ($vehicleOwner->isVerified())
                    <h3 class="mb-2 p-4 text-lg font-medium bg-green-100 text-green-600">
                        Business account verified
                    </h3>
                @else
                    <h3 class="mb-2 p-4 text-lg font-medium bg-red-100 text-orange-600">
                        Business account under review
                    </h3>
                @endif
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div>
                        <p class="p-3 text-gray-700 rounded-md bg-gray-50">
                            Details Verification @if ($vehicleOwner->isVerified())
                                <span class="bg-green-200 text-green-600 p-2 rounded-xl text-sm">Verified</span>
                            @else
                                <span class="bg-red-200 text-orange-600 p-2 rounded-xl w-full text-sm">Pending</span>
                            @endif
                        </p>
                        @if (!$vehicleOwner->isVerified())
                            <button wire:click='verifyVehicleOwner'
                                class="flex items-center gap-2 px-4 py-2 bg-gold-600  rounded-md hover:bg-gold-700 focus:outline-none focus:ring-2 focus:ring-gold-500">
                                <x-icons.pencil-square />
                                Verify Details
                            </button>
                        @endif
                    </div>
                    <div>
                        <p class="p-3 text-gray-700 rounded-md bg-gray-50">
                            Documents verification
                            @if ($vehicleOwner->isDocumentsVerified())
                                <span class="bg-green-200 text-green-600 p-2 rounded-xl text-sm">Verified</span>
                            @else
                                <span class="bg-red-200 text-orange-600 p-2 rounded-xl w-full text-sm">Pending</span>
                            @endif
                            {{-- isDocumentsVerified() --}}
                        </p>
                        @if (!$vehicleOwner->isDocumentsVerified())
                            <button wire:click='verifyVehicleOwnerDocuments'
                                class="flex items-center gap-2 px-4 py-2 bg-gold-600  rounded-md hover:bg-gold-700 focus:outline-none focus:ring-2 focus:ring-gold-500">
                                <x-icons.pencil-square />
                                Verify Documents
                            </button>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="flex col-span-2 gap-3 mt-3 mb-3">
        <div class="w-full p-4 bg-white border border-gray-200 rounded-md shadow-sm">
            <div class="flex items-end justify-between mb-4">
                <button>
                    <x-icons.pencil-square />
                    <livewire:admin.vehicle-owners.users.user-stats id="{{ $vehicleOwner->id }}" wire:lazy />
                </button>
            </div>
        </div>
        <div class="w-full p-4 bg-white border border-gray-200 rounded-md shadow-sm">
            <div class="flex items-end justify-between mb-4">
                <button>
                    <x-icons.pencil-square />
                    <livewire:admin.vehicle-owners.fleets.fleet-stats id="{{ $vehicleOwner->id }}" wire:lazy />
                </button>
            </div>
        </div>
    </div>
    <div class="px-4 py-4 mt-5 bg-white shadow-lg rounded-2xl">
        <h1 class="mb-6 text-2xl font-semibold text-gray-800">Billings and Payments</h1>
        <!-- Payment Summary -->
        <div class="grid grid-cols-1 gap-6 mb-8 md:grid-cols-3">
            <div class="p-4 rounded-lg bg-red-50">
                <p class="text-sm text-yellow-600">Pending Charges</p>
                <div class="flex items-end justify-between">
                    <div>
                        <p class="text-2xl font-bold text-gray-800">45</p>
                        <p class="text-sm text-gray-500">Charges</p>
                    </div>
                    <p class="text-2xl font-bold text-gray-800">$45450.00</p>
                </div>
            </div>
            <div class="p-4 rounded-lg bg-red-50">
                <livewire:admin.vehicle-owners.b-illing.invoices.invoice-stats id="{{ $vehicleOwner->id }}"
                    wire:lazy />
            </div>
        </div>
    </div>
    <!-- Payment History Table -->
    <!-- Payment Action Section -->
</div>
</div>
