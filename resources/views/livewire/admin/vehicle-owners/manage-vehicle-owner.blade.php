<div class="mx-auto max-w-12xl sm:px-6 lg:px-8">
    <div class="overflow-hidden bg-white rounded-lg ">
        <!-- Header -->
        <div class="p-2">
            <h1 class="text-xl font-semibold text-white">Vehicle Owner Details</h1>
            <div class="flex justify-between gap-2">
                <div class="justify-start">
                    <x-gold-button-link-sm href="{{ route('admin.vehicle-owners') }}" wire:navigate>
                        <x-icons.arrow-left />
                        Back
                    </x-gold-button-link-sm>
                </div>
                <div class="justify-end">
                    <x-gold-button-link href="{{ route('admin.vehicle-owners.users', $vehicleOwner) }}" wire:navigate>
                        <x-icons.pencil-square />
                        Users
                    </x-gold-button-link>
                    <x-gold-button-link href="{{ route('admin.vehicle-owners.fleets', $vehicleOwner) }}" wire:navigate>
                        <x-icons.pencil-square />
                        Fleet
                    </x-gold-button-link>
                </div>
            </div>
        </div>
        <!-- Content -->
        <div class="p-6">
            <div class="mb-8">
                <h2 class="pb-2 text-2xl font-bold text-gray-800 border-b border-gray-200">{{ $vehicleOwner->business_name }}
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
            <x-gold-button-link href="{{ route('admin.vehicle-owners.edit', $vehicleOwner) }}" wire:navigate>
                <x-icons.pencil-square />
                Edit Details
            </x-gold-button-link>
        </div>
