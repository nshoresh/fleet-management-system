<div>
    <x-slot name="header">
        <div class="px-4 py-2 bg-gradient-to-r from-yellow-200 to-yellow-100">
            <h2 class="text-xl text-center font-semibold text-orange-600">
                {{ __('License Application') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-6 mx-auto max-w-12xl sm:px-6 lg:px-8">
        <div class="mt-5 md:mt-0 md:col-span-2">

            {{-- Error + Success Alerts --}}
            @if (session()->has('error'))
                <div class="relative px-4 py-3 mb-4 text-red-700 bg-red-100 border border-red-400 rounded"
                    role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            @if (session()->has('success'))
                <div class="relative px-4 py-3 mb-4 text-green-700 bg-green-100 border border-green-400 rounded"
                    role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <form wire:submit.prevent="submitApplication">
                <div class="overflow-hidden shadow rounded-2xl sm:rounded-2xl">
                    <div class="px-4 py-5 bg-white sm:p-6">

                        {{-- Selected Vehicle Info --}}
                        @if($selectedVehicle)
                            <h1 class="mb-4 font-medium text-yellow-700">Selected Vehicle Information</h1>
                            <div class="p-4 mb-6 bg-yellow-50 rounded-lg grid grid-cols-1 md:grid-cols-3 gap-4">
                                <p class="text-sm font-medium text-gray-700">License Plate: 
                                    <b>{{ $selectedVehicle->license_plate }}</b>
                                </p>
                                <p class="text-sm font-medium text-gray-700">VIN: 
                                    <b>{{ $selectedVehicle->vin }}</b>
                                </p>
                                <p class="text-sm font-medium text-gray-700">Make: 
                                    <b>{{ $selectedVehicle->make?->name ?? 'N/A' }}</b>
                                </p>
                                <p class="text-sm font-medium text-gray-700">Model: 
                                    <b>{{ $selectedVehicle->makeModel?->name ?? 'N/A' }}</b>
                                </p>
                                <p class="text-sm font-medium text-gray-700">Color: 
                                    <b>{{ $selectedVehicle->color ?? 'N/A' }}</b>
                                </p>
                                <p class="text-sm font-medium text-gray-700">Payload: 
                                    <b>{{ $selectedVehicle->payload_capacity ?? 'N/A' }}</b>
                                </p>
                                <p class="text-sm font-medium text-gray-700">Status:
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                        @if ($selectedVehicle->status === 'active') bg-green-100 text-green-800
                                        @elseif($selectedVehicle->status === 'inactive') bg-yellow-100 text-yellow-800
                                        @else bg-red-100 text-red-800 @endif">
                                        {{ ucfirst($selectedVehicle->status) }}
                                    </span>
                                </p>
                            </div>
                        @endif

                        {{-- License Application Form --}}
                        <h1 class="mb-4 font-medium text-yellow-700">Application Details</h1>
                        <div class="p-4 grid grid-cols-6 bg-yellow-50 gap-6">

                            <!-- Vehicle Dropdown -->
                            <div class="col-span-6 sm:col-span-3">
                                <label for="vehicle_id" class="block text-sm font-medium text-gray-700">Select Vehicle</label>
                                <select wire:model="vehicle_id" id="vehicle_id"
                                    class="block w-full border-gray-300 rounded-sm shadow-sm focus:border-yellow-500 focus:ring-yellow-500 sm:text-sm"
                                    @if($vehicle_id) disabled @endif>
                                    <option value="">-- Choose Vehicle --</option>
                                    @foreach($vehicles as $vehicle)
                                        <option value="{{ $vehicle->id }}">
                                            {{ $vehicle->license_plate }} ({{ $vehicle->make?->name ?? 'N/A' }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('vehicle_id') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                            </div>

                            <!-- License Type -->
                            <div class="col-span-6 sm:col-span-3">
                                <label for="license-type" class="block text-sm font-medium text-gray-700">License Type</label>
                                <select wire:model="selectedLicenseType" id="license-type"
                                    class="block w-full border-gray-300 rounded-sm shadow-sm focus:border-yellow-500 focus:ring-yellow-500 sm:text-sm">
                                    <option value="">-- Choose License Type --</option>
                                    @foreach($license_type as $licenseType)
                                        <option value="{{ $licenseType->id }}">{{ $licenseType->type_name }}</option>
                                    @endforeach
                                </select>
                                @error('selectedLicenseType') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                            </div>

                            <!-- Application Number -->
                            <div class="col-span-6 sm:col-span-3">
                                <label for="application-number" class="block text-sm font-medium text-gray-700">Application Number</label>
                                <x-gold-text-input wire:model="applicationNumber" id="application-number" type="text"
                                    placeholder="Unique application number" />
                                @error('applicationNumber') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                            </div>

                            <!-- Registration Number -->
                            <div class="col-span-6 sm:col-span-3">
                                <label for="registration-number" class="block text-sm font-medium text-gray-700">Registration Number</label>
                                <x-gold-text-input wire:model="registrationNumber" id="registration-number" type="text" placeholder="Enter registration number" />
                                @error('registrationNumber') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                            </div>


                            <!-- Submission Date -->
                            <div class="col-span-6 sm:col-span-3">
                                <label for="submission-date" class="block text-sm font-medium text-gray-700">Submission Date</label>
                                <x-gold-text-input wire:model="submissionDate" id="submission-date" type="date" />
                                @error('submissionDate') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                            </div>

                            <!-- Expiry Date -->
                            <div class="col-span-6 sm:col-span-3">
                                <label for="expiry-date" class="block text-sm font-medium text-gray-700">Expiry Date</label>
                                <x-gold-text-input wire:model="expiryDate" id="expiry-date" type="date" />
                                @error('expiryDate') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                            </div>

                            <!-- Purpose -->
                            <div class="col-span-6">
                                <label for="purpose" class="block text-sm font-medium text-gray-700">Purpose</label>
                                <textarea wire:model="purpose" id="purpose" rows="3"
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-yellow-500 focus:ring-yellow-500 sm:text-sm"
                                    placeholder="Purpose of the license application..."></textarea>
                                @error('purpose') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                            </div>

                            <!-- Supporting Documents -->
                            <div class="col-span-6">
                                <label for="supporting-documents" class="block text-sm font-medium text-gray-700">Supporting Documents</label>
                                <input wire:model="supportingDocuments" id="supporting-documents" type="file" multiple
                                    class="block w-full mt-1 text-sm border-gray-300 rounded-md shadow-sm focus:border-yellow-500 focus:ring-yellow-500" />
                                @error('supportingDocuments') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                            </div>

                            <!-- Additional Information -->
                            <div class="col-span-6">
                                <label for="additional-information" class="block text-sm font-medium text-gray-700">Additional Information</label>
                                <textarea wire:model="additionalInformation" id="additional-information" rows="3"
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-yellow-500 focus:ring-yellow-500 sm:text-sm"
                                    placeholder="Additional information about the license application..."></textarea>
                                @error('additionalInformation') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Footer Buttons --}}
                    <div class="px-4 py-3 text-right bg-gray-50 sm:px-6">
                        <button type="button" wire:click="resetForm"
                            class="inline-flex justify-center px-4 py-2 mr-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                            Cancel
                        </button>
                        <x-gold-button type="submit"
                            class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Submit Application
                        </x-gold-button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
