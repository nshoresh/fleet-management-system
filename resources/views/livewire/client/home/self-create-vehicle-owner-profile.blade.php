<div class="mx-auto my-10 overflow-auto bg-white shadow-xl max-w-7xl rounded-3xl">
    <!-- Progress Bar -->
    <div class="px-8 py-8 border-b border-gray-200 bg-gradient-to-r from-orange-900 to-yellow-500">
        <div class="flex items-center justify-between mb-2">
            <div class="text-sm font-semibold text-white">
                Step {{ $currentStep }} of {{ $totalSteps }}
            </div>
            <div class="text-sm font-medium text-white">{{ $stepProgress }}% Complete</div>
        </div>
        <div class="relative h-2.5 w-full overflow-hidden rounded-full bg-gray-400">
            <div class="absolute left-0 top-0 h-2.5 rounded-full bg-yellow-400 transition-all duration-300"
                style="width: {{ $stepProgress }}%"></div>
        </div>
    </div>
    <div class="px-8 py-8">
        {{--  Display Session Error --}}
        @if (session('error'))
            <div class="w-full px-4 py-6 text-red-600 bg-red-300">
                <p>{{ session('error') }}</p>
            </div>
        @endif
        @if (session('success'))
            <div class="w-full px-4 py-6 text-green-600 bg-green-300">
                <p>{{ session('success') }}</p>
            </div>
        @endif
        <!-- Step 1: Business Information -->
        @if ($currentStep === 1)
            <h2 class="mb-6 text-2xl font-bold text-gray-800">{{ $step_title }}</h2>
            <div class="grid gap-6 md:grid-cols-2">
                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">Business Name</label>
                    <x-gold-text-input type="text" wire:model.defer="business_name"
                        class="block w-full py-4 text-base text-gray-900 placeholder-gray-400 transition-all duration-300 border-2 border-gray-200 rounded pl-14 pr-14 bg-gray-50/50 focus:border-yellow-500 focus:bg-white focus:ring-4 focus:ring-yellow-500/20 hover:border-yellow-300 hover:bg-white/70" />
                    @error('business_name')
                        <span class="mt-1 text-xs text-red-600">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">Business Type</label>
                    <select wire:model.defer="vehicle_owner_type_id"
                        class="block w-full py-4 text-base text-gray-900 placeholder-gray-400 transition-all duration-300 border-2 border-gray-200 rounded pl-14 pr-14 bg-gray-50/50 focus:border-yellow-500 focus:bg-white focus:ring-4 focus:ring-yellow-500/20 hover:border-yellow-300 hover:bg-white/70">
                        <option value="">Select type</option>
                        @foreach ($vehicle_owner_types as $businessType)
                            <option value="{{ $businessType->id }}">{{ $businessType->name }}</option>
                        @endforeach
                    </select>
                    @error('business_type')
                        <span class="mt-1 text-xs text-red-600">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">Business Phone</label>
                    <x-gold-text-input type="text" wire:model.defer="business_phone"
                        class="block w-full py-4 text-base text-gray-900 placeholder-gray-400 transition-all duration-300 border-2 border-gray-200 rounded pl-14 pr-14 bg-gray-50/50 focus:border-yellow-500 focus:bg-white focus:ring-4 focus:ring-yellow-500/20 hover:border-yellow-300 hover:bg-white/70" />
                    @error('business_phone')
                        <span class="mt-1 text-xs text-red-600">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">Business Email</label>
                    <x-gold-text-input type="email" wire:model.defer="business_email"
                        class="block w-full py-4 text-base text-gray-900 placeholder-gray-400 transition-all duration-300 border-2 border-gray-200 rounded pl-14 pr-14 bg-gray-50/50 focus:border-yellow-500 focus:bg-white focus:ring-4 focus:ring-yellow-500/20 hover:border-yellow-300 hover:bg-white/70" />
                    @error('business_email')
                        <span class="mt-1 text-xs text-red-600">{{ $message }}</span>
                    @enderror
                </div>
                <div class="md:col-span-2">
                    <label class="block mb-1 text-sm font-medium text-gray-700">Business Address</label>
                    <textarea wire:model.defer="business_address" rows="3"
                        class="block w-full py-3 text-base text-gray-900 transition-all duration-300 border-2 border-gray-200 rounded-2xl bg-gray-50/50 focus:border-yellow-500 focus:bg-white focus:ring-4 focus:ring-yellow-500/20 hover:border-gray-300 hover:bg-white/70"></textarea>
                    @error('business_address')
                        <span class="mt-1 text-xs text-red-600">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">Registration Number</label>
                    <x-gold-text-input type="text" wire:model.defer="business_registration_number"
                        class="block w-full py-4 text-base text-gray-900 placeholder-gray-400 transition-all duration-300 border-2 border-gray-200 rounded pl-14 pr-14 bg-gray-50/50 focus:border-yellow-500 focus:bg-white focus:ring-4 focus:ring-yellow-500/20 hover:border-yellow-300 hover:bg-white/70" />
                    @error('business_registration_number')
                        <span class="mt-1 text-xs text-red-600">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">Registration Date</label>
                    <x-gold-text-input type="date" wire:model.defer="business_registration_date"
                        class="block w-full py-4 text-base text-gray-900 placeholder-gray-400 transition-all duration-300 border-2 border-gray-200 rounded pl-14 pr-14 bg-gray-50/50 focus:border-yellow-500 focus:bg-white focus:ring-4 focus:ring-yellow-500/20 hover:border-yellow-300 hover:bg-white/70" />
                    @error('business_registration_date')
                        <span class="mt-1 text-xs text-red-600">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">Contact Person</label>
                    <x-gold-text-input type="text" wire:model.defer="business_contact_person"
                        class="block w-full py-4 text-base text-gray-900 placeholder-gray-400 transition-all duration-300 border-2 border-gray-200 rounded pl-14 pr-14 bg-gray-50/50 focus:border-yellow-500 focus:bg-white focus:ring-4 focus:ring-yellow-500/20 hover:border-yellow-300 hover:bg-white/70" />
                    @error('business_contact_person')
                        <span class="mt-1 text-xs text-red-600">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">Contact's Phone Number</label>
                    <x-gold-text-input type="test" wire:model.defer="business_contact_number"
                        class="block w-full py-4 text-base text-gray-900 placeholder-gray-400 transition-all duration-300 border-2 border-gray-200 rounded pl-14 pr-14 bg-gray-50/50 focus:border-yellow-500 focus:bg-white focus:ring-4 focus:ring-yellow-500/20 hover:border-yellow-300 hover:bg-white/70" />
                    @error('business_contact_number')
                        <span class="mt-1 text-xs text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                {{-- position --}}
            </div>
        @endif
        <!-- Step 2: Owner/Representative Information -->
        @if ($currentStep === 2)
            <h2 class="mb-6 text-2xl font-bold text-gray-800">Owner/Representative Information</h2>
            <div class="grid gap-6 md:grid-cols-2">
                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">Full Name</label>
                    <x-gold-text-input type="text" wire:model.defer="name"
                        class="block w-full py-3 text-base text-gray-900 transition-all duration-300 border-2 border-gray-200 rounded-2xl bg-gray-50/50 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/20 hover:border-gray-300 hover:bg-white/70" />
                    @error('name')
                        <span class="mt-1 text-xs text-red-600">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">Contact Phone</label>
                    <x-gold-text-input type="text" wire:model.defer="contact_number"
                        class="block w-full py-3 text-base text-gray-900 transition-all duration-300 border-2 border-gray-200 rounded-2xl bg-gray-50/50 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/20 hover:border-gray-300 hover:bg-white/70" />
                    @error('contact_number')
                        <span class="mt-1 text-xs text-red-600">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">Email</label>
                    <x-gold-text-input type="email" wire:model.defer="email"
                        class="block w-full py-3 text-base text-gray-900 transition-all duration-300 border-2 border-gray-200 rounded-2xl bg-gray-50/50 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/20 hover:border-gray-300 hover:bg-white/70" />
                    @error('email')
                        <span class="mt-1 text-xs text-red-600">{{ $message }}</span>
                    @enderror
                </div>


                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">Position</label>
                    <x-gold-text-input type="text" wire:model.defer="position"
                        class="block w-full py-3 text-base text-gray-900 transition-all duration-300 border-2 border-gray-200 rounded-2xl bg-gray-50/50 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/20 hover:border-gray-300 hover:bg-white/70" />
                    @error('position')
                        <span class="mt-1 text-xs text-red-600">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">ID Number</label>
                    <x-gold-text-input type="text" wire:model.defer="id_number"
                        class="block w-full py-3 text-base text-gray-900 transition-all duration-300 border-2 border-gray-200 rounded-2xl bg-gray-50/50 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/20 hover:border-gray-300 hover:bg-white/70" />
                    @error('id_number')
                        <span class="mt-1 text-xs text-red-600">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">ID Type</label>
                    <select wire:model.defer="id_type"
                        class="block w-full py-3 text-base text-gray-900 transition-all duration-300 border-2 border-gray-200 rounded-2xl bg-gray-50/50 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/20 hover:border-gray-300 hover:bg-white/70">
                        @foreach ($id_types as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('id_type')
                        <span class="mt-1 text-xs text-red-600">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">Address</label>
                <textarea rows="3" wire:model.defer="address"
                    class="block w-full py-3 text-base text-gray-900 transition-all duration-300 border-2 border-gray-200 rounded-2xl bg-gray-50/50 focus:border-yellow-500 focus:bg-white focus:ring-4 focus:ring-yellow-500/20 hover:border-gray-300 hover:bg-white/70"></textarea>
                @error('address')
                    <span class="mt-1 text-xs text-red-600">{{ $message }}</span>
                @enderror
            </div>
        @endif

        <!-- Step 3: Document Uploads -->
        @if ($currentStep === 3)
            <div class="mx-auto max-w-12xl">
                <!-- Header Section -->
                <div class="mb-8 text-center">
                    <h2 class="mb-3 text-3xl font-bold text-gray-900">Document Verification</h2>
                    <p class="max-w-2xl mx-auto text-base text-gray-600">
                        Please upload the required documents to complete your registration. All files should be clear,
                        legible, and in PDF, JPG, or PNG format.
                    </p>
                </div>

                <!-- Upload Grid -->
                <div class="grid gap-6 md:grid-cols-2">
                    <!-- Registration Certificate -->
                    <div class="relative group">
                        <div
                            class="p-6 transition-all duration-300 bg-white border border-gray-200 shadow-sm rounded-xl hover:shadow-md">
                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0">
                                    <div class="flex items-center justify-center w-12 h-12 rounded-lg bg-blue-50">
                                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                            </path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <label class="block mb-2 text-sm font-semibold text-gray-900">
                                        Registration Certificate
                                        <span class="ml-1 text-red-500">*</span>
                                    </label>
                                    <p class="mb-3 text-xs text-gray-500">Business registration or incorporation
                                        certificate</p>
                                    <x-gold-text-input type="file" wire:model="registration_certificate"
                                        accept=".pdf,.jpg,.jpeg,.png"
                                        class="block w-full text-sm text-gray-600 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 file:cursor-pointer cursor-pointer border-2 border-dashed border-gray-300 rounded-lg p-4 hover:border-blue-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-300" />
                                    @error('registration_certificate')
                                        <div class="flex items-center mt-2 text-xs text-red-600">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ID Document -->
                    <div class="relative group">
                        <div
                            class="p-6 transition-all duration-300 bg-white border border-gray-200 shadow-sm rounded-xl hover:shadow-md">
                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0">
                                    <div class="flex items-center justify-center w-12 h-12 rounded-lg bg-green-50">
                                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V4a2 2 0 114 0v2m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2">
                                            </path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <label class="block mb-2 text-sm font-semibold text-gray-900">
                                        ID Document
                                        <span class="ml-1 text-red-500">*</span>
                                    </label>
                                    <p class="mb-3 text-xs text-gray-500">Valid government-issued identification</p>
                                    <x-gold-text-input type="file" wire:model="id_document"
                                        accept=".pdf,.jpg,.jpeg,.png"
                                        class="block w-full text-sm text-gray-600 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-green-50 file:text-green-700 hover:file:bg-green-100 file:cursor-pointer cursor-pointer border-2 border-dashed border-gray-300 rounded-lg p-4 hover:border-green-400 focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all duration-300" />
                                    @error('id_document')
                                        <div class="flex items-center mt-2 text-xs text-red-600">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tax Clearance -->
                    <div class="relative group">
                        <div
                            class="p-6 transition-all duration-300 bg-white border border-gray-200 shadow-sm rounded-xl hover:shadow-md">
                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0">
                                    <div class="flex items-center justify-center w-12 h-12 rounded-lg bg-purple-50">
                                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <label class="block mb-2 text-sm font-semibold text-gray-900">
                                        Tax Clearance
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 ml-2 text-xs font-medium bg-gray-100 text-gray-700 rounded-full">Optional</span>
                                    </label>
                                    <p class="mb-3 text-xs text-gray-500">Current tax clearance certificate</p>
                                    <x-gold-text-input type="file" wire:model="tax_clearance"
                                        accept=".pdf,.jpg,.jpeg,.png"
                                        class="block w-full text-sm text-gray-600 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100 file:cursor-pointer cursor-pointer border-2 border-dashed border-gray-300 rounded-lg p-4 hover:border-purple-400 focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 transition-all duration-300" />
                                    @error('tax_clearance')
                                        <div class="flex items-center mt-2 text-xs text-red-600">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Proof of Address -->
                    <div class="relative group">
                        <div
                            class="p-6 transition-all duration-300 bg-white border border-gray-200 shadow-sm rounded-xl hover:shadow-md">
                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0">
                                    <div class="flex items-center justify-center w-12 h-12 rounded-lg bg-orange-50">
                                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                            </path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <label class="block mb-2 text-sm font-semibold text-gray-900">
                                        Proof of Address
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 ml-2 text-xs font-medium bg-gray-100 text-gray-700 rounded-full">Optional</span>
                                    </label>
                                    <p class="mb-3 text-xs text-gray-500">Utility bill or bank statement (within 3
                                        months)</p>
                                    <x-gold-text-input type="file" wire:model="proof_of_address"
                                        accept=".pdf,.jpg,.jpeg,.png"
                                        class="block w-full text-sm text-gray-600 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100 file:cursor-pointer cursor-pointer border-2 border-dashed border-gray-300 rounded-lg p-4 hover:border-orange-400 focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all duration-300" />
                                    @error('proof_of_address')
                                        <div class="flex items-center mt-2 text-xs text-red-600">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer Information -->
                <div class="p-4 mt-8 border border-blue-200 bg-blue-50 rounded-xl">
                    <div class="flex items-start space-x-3">
                        <svg class="w-5 h-5 text-blue-600 mt-0.5 flex-shrink-0" fill="currentColor"
                            viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <div>
                            <h4 class="mb-1 text-sm font-semibold text-blue-900">Document Requirements</h4>
                            <ul class="space-y-1 text-sm text-blue-800">
                                <li>• Maximum file size: 10MB per document</li>
                                <li>• Accepted formats: PDF, JPG, JPEG, PNG</li>
                                <li>• Documents must be clear and legible</li>
                                <li>• Personal information should be visible and not obscured</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Step 4: Verification & Submission -->
        @if ($currentStep === 4)
            <h2 class="mb-6 text-2xl font-bold text-gray-800">Verification & Submission</h2>
            <div class="space-y-6">
                <div>
                    <label class="flex items-start">
                        <input type="checkbox" wire:model.defer="terms_accepted"
                            class="mt-0.5 h-4 w-4 rounded border-gray-300 text-yellow-600 focus:ring-yellow-500" />
                        <span class="ml-3 text-sm text-gray-700">I accept the Terms and Conditions</span>
                    </label>
                    @error('terms_accepted')
                        <span class="mt-1 text-xs text-red-600">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label class="flex items-start">
                        <input type="checkbox" wire:model.defer="privacy_accepted"
                            class="mt-0.5 h-4 w-4 rounded border-gray-300 text-yellow-600 focus:ring-yellow-500" />
                        <span class="ml-3 text-sm text-gray-700">I accept the Privacy Policy</span>
                    </label>
                    @error('privacy_accepted')
                        <span class="mt-1 text-xs text-red-600">{{ $message }}</span>
                    @enderror
                </div>
                <!-- Add verification code input and submit button as needed -->
            </div>
        @endif

        <!-- Step Controls -->
        <div class="flex justify-between mt-10">
            @if ($currentStep > 1)
                <button type="button" wire:click="previousStep"
                    class="px-6 py-2 font-semibold text-gray-700 transition bg-gray-200 rounded-lg hover:bg-gray-300">Previous</button>
            @endif
            @if ($currentStep < $totalSteps)
                <button type="button" wire:click="nextStep"
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-yellow-600 border border-transparent rounded-lg shadow-sm hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2">Next
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-arrow-right" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                            d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8" />
                    </svg>

                </button>
            @elseif ($currentStep === $totalSteps)
                <x-gold-button type="button" wire:click="submitRegistration"
                    class="px-6 py-2 font-semibold text-white transition bg-green-600 rounded-lg hover:bg-green-700">Submit</x-gold-button>
            @endif
        </div>

    </div>
</div>
