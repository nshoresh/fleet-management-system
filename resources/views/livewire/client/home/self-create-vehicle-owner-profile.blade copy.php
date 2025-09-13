<div class="mx-auto my-10 overflow-hidden bg-white shadow-lg max-w-7xl rounded-2xl">
    <!-- Progress Bar -->
    <div class="px-8 py-8 bg-gray-200 border-b border-gray-200">
        <div class="flex items-center justify-between mb-2">
            <div class="text-sm font-semibold text-gray-700">
                Step {{ $currentStep }} of {{ $totalSteps }}
            </div>
            <div class="text-sm font-medium text-gray-500">{{ $stepProgress }}% Complete</div>
        </div>
        <div class="relative h-2.5 w-full overflow-hidden rounded-full bg-gray-400">
            <div class="absolute left-0 top-0 h-2.5 rounded-full bg-green-600 transition-all duration-300"
                style="width: {{ $stepProgress }}%"></div>
        </div>
    </div>

    <div class="px-8 py-8">
        <!-- Step 1: Business Information -->
        @if ($currentStep === 1)
        <h2 class="mb-6 text-2xl font-bold text-gray-800">Business Information</h2>
        <div class="grid gap-6 md:grid-cols-2">
            <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">Business Name</label>
                <x-gold-text-input type="text" wire:model.defer="name"
                    class="block w-full py-4 text-base text-gray-900 placeholder-gray-400 transition-all duration-300 border-2 border-gray-200 pl-14 pr-14 rounded-2xl bg-gray-50/50 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/20 hover:border-gray-300 hover:bg-white/70" />
                @error('business_name')
                <span class="mt-1 text-xs text-red-600">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">Business Type</label>
                <select wire:model.defer="business_type"
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
                <x-gold-text-input type="text" wire:model.live.debounce.300ms="business_phone"
                    class="block w-full py-4 text-base text-gray-900 placeholder-gray-400 transition-all duration-300 border-2 border-gray-200 pl-14 pr-14 rounded-2xl bg-gray-50/50 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/20 hover:border-gray-300 hover:bg-white/70" />
                @error('business_phone')
                <span class="mt-1 text-xs text-red-600">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">Business Email</label>
                <x-gold-text-input type="email" wire:model.live.debounce.300ms="business_email"
                    class="block w-full py-4 text-base text-gray-900 placeholder-gray-400 transition-all duration-300 border-2 border-gray-200 pl-14 pr-14 rounded-2xl bg-gray-50/50 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/20 hover:border-gray-300 hover:bg-white/70" />
                @error('business_email')
                <span class="mt-1 text-xs text-red-600">{{ $message }}</span>
                @enderror
            </div>
            <div class="md:col-span-2">
                <label class="block mb-1 text-sm font-medium text-gray-700">Business Address</label>
                <textarea wire:model.defer="business_address" rows="3"
                    class="block w-full py-4 text-base text-gray-900 placeholder-gray-400 transition-all duration-300 border-2 border-gray-200 pl-14 pr-14 rounded-2xl bg-gray-50/50 focus:border-yellow-500 focus:bg-white focus:ring-4 focus:ring-yellow-500/20 hover:border-gray-300 hover:bg-white/70"></textarea>
                @error('business_address')
                <span class="mt-1 text-xs text-red-600">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">Registration Number</label>
                <x-gold-text-input type="text" wire:model.debounce.300ms="registration_number"
                    class="block w-full py-4 text-base text-gray-900 placeholder-gray-400 transition-all duration-300 border-2 border-gray-200 pl-14 pr-14 rounded-2xl bg-gray-50/50 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/20 hover:border-gray-300 hover:bg-white/70" />
                @error('registration_number')
                <span class="mt-1 text-xs text-red-600">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">Registration Date</label>
                <x-gold-text-input type="date" wire:model.defer="registration_date"
                    class="block w-full py-4 text-base text-gray-900 placeholder-gray-400 transition-all duration-300 border-2 border-gray-200 pl-14 pr-14 rounded-2xl bg-gray-50/50 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/20 hover:border-gray-300 hover:bg-white/70" />
                @error('registration_date')
                <span class="mt-1 text-xs text-red-600">{{ $message }}</span>
                @enderror
            </div>
        </div>
        @endif

        <!-- Step 2: Owner/Representative Information -->
        @if ($currentStep === 2)
        <h2 class="mb-6 text-2xl font-bold text-gray-800">Owner/Representative Information</h2>
        <div class="grid gap-6 md:grid-cols-2">
            <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">Full Name</label>
                <x-gold-text-input type="text" wire:model.defer="name"
                    class="block w-full py-4 text-base text-gray-900 placeholder-gray-400 transition-all duration-300 border-2 border-gray-200 pl-14 pr-14 rounded-2xl bg-gray-50/50 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/20 hover:border-gray-300 hover:bg-white/70" />
                @error('name')
                <span class="mt-1 text-xs text-red-600">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">Phone</label>
                <x-gold-text-input type="text" wire:model.defer="contact_number"
                    class="block w-full py-4 text-base text-gray-900 placeholder-gray-400 transition-all duration-300 border-2 border-gray-200 pl-14 pr-14 rounded-2xl bg-gray-50/50 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/20 hover:border-gray-300 hover:bg-white/70" />
                @error('contact_number')
                <span class="mt-1 text-xs text-red-600">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">Email</label>
                <x-gold-text-input type="email" wire:model.defer="email"
                    class="block w-full py-4 text-base text-gray-900 placeholder-gray-400 transition-all duration-300 border-2 border-gray-200 pl-14 pr-14 rounded-2xl bg-gray-50/50 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/20 hover:border-gray-300 hover:bg-white/70" />
                @error('email')
                <span class="mt-1 text-xs text-red-600">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">Position</label>
                <x-gold-text-input type="text" wire:model.defer="owner_position"
                    class="block w-full py-4 text-base text-gray-900 placeholder-gray-400 transition-all duration-300 border-2 border-gray-200 pl-14 pr-14 rounded-2xl bg-gray-50/50 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/20 hover:border-gray-300 hover:bg-white/70" />
                @error('owner_position')
                <span class="mt-1 text-xs text-red-600">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">ID Number</label>
                <x-gold-text-input type="text" wire:model.defer="id_number"
                    class="block w-full py-4 text-base text-gray-900 placeholder-gray-400 transition-all duration-300 border-2 border-gray-200 pl-14 pr-14 rounded-2xl bg-gray-50/50 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/20 hover:border-gray-300 hover:bg-white/70" />
                @error('id_number')
                <span class="mt-1 text-xs text-red-600">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">ID Type</label>
                <select wire:model.defer="id_type"
                    class="block w-full py-4 text-base text-gray-900 placeholder-gray-400 transition-all duration-300 border-2 border-gray-200 pl-14 pr-14 rounded-2xl bg-gray-50/50 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/20 hover:border-gray-300 hover:bg-white/70">
                    @foreach ($id_types as $key => $label)
                    <option value="{{ $key }}">{{ $label }}</option>
                    @endforeach
                </select>
                @error('id_type')
                <span class="mt-1 text-xs text-red-600">{{ $message }}</span>
                @enderror
            </div>
        </div>
        @endif

        <!-- Step 3: Document Uploads -->
        @if ($currentStep === 3)
        <h2 class="mb-6 text-2xl font-bold text-gray-800">Document Uploads</h2>
        <div class="grid gap-6">
            <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">Registration Certificate <span
                        class="text-red-500">*</span></label>
                <div class="flex items-center mt-1">
                    <x-gold-text-input type="file" wire:model="registration_certificate"
                        class="block w-full py-4 text-base text-gray-900 placeholder-gray-400 transition-all duration-300 border-2 border-gray-200 pl-14 pr-14 rounded-2xl bg-gray-50/50 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/20 hover:border-gray-300 hover:bg-white/70" />
                </div>
                @error('registration_certificate')
                <span class="mt-1 text-xs text-red-600">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">ID Document <span
                        class="text-red-500">*</span></label>
                <div class="flex items-center mt-1">
                    <x-gold-text-input type="file" wire:model="id_document"
                        class="block w-full py-4 text-base text-gray-900 placeholder-gray-400 transition-all duration-300 border-2 border-gray-200 pl-14 pr-14 rounded-2xl bg-gray-50/50 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/20 hover:border-gray-300 hover:bg-white/70" />
                </div>
                @error('id_document')
                <span class="mt-1 text-xs text-red-600">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">Tax Clearance (optional)</label>
                <div class="flex items-center mt-1">
                    <x-gold-text-input type="file" wire:model="tax_clearance"
                        class="block w-full py-4 text-base text-gray-900 placeholder-gray-400 transition-all duration-300 border-2 border-gray-200 pl-14 pr-14 rounded-2xl bg-gray-50/50 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/20 hover:border-gray-300 hover:bg-white/70" />
                </div>
                @error('tax_clearance')
                <span class="mt-1 text-xs text-red-600">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">Proof of Address (optional)</label>
                <div class="flex items-center mt-1">
                    <x-gold-text-input type="file" wire:model="proof_of_address"
                        class="block w-full py-4 text-base text-gray-900 placeholder-gray-400 transition-all duration-300 border-2 border-gray-200 pl-14 pr-14 rounded-2xl bg-gray-50/50 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/20 hover:border-gray-300 hover:bg-white/70" />
                </div>
                @error('proof_of_address')
                <span class="mt-1 text-xs text-red-600">{{ $message }}</span>
                @enderror
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
            <div class="p-4 rounded-lg bg-gray-50">
                <label class="block mb-2 text-sm font-medium text-gray-700">Email Verification</label>
                @if (!$is_verified)
                @if (!$verification_code_sent)
                <button wire:click="sendVerificationCode"
                    class="px-4 py-2 text-sm font-medium text-white bg-yellow-600 rounded-lg shadow-sm hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2">
                    Send Verification Code
                </button>
                @else
                <div class="flex flex-col space-y-3 sm:flex-row sm:items-center sm:space-x-3 sm:space-y-0">
                    <x-gold-text-input type="text" maxlength="6"
                        wire:model.defer="verification_code_input" placeholder="Enter code"
                        class="block w-full py-4 text-base text-gray-900 placeholder-gray-400 transition-all duration-300 border-2 border-gray-200 pl-14 pr-14 rounded-2xl bg-gray-50/50 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/20 hover:border-gray-300 hover:bg-white/70" />
                    <button wire:click="verifyCode"
                        class="px-4 py-2 text-sm font-medium text-white bg-yellow-600 rounded-lg shadow-sm hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow500 focus:ring-offset-2">
                        Verify
                    </button>
                    @if (!$can_resend_code)
                    <span class="text-xs text-gray-500">Wait {{ $resend_cooldown }}s to resend</span>
                    @else
                    <x-gold-button wire:click="sendVerificationCode"
                        class="rounded-lg bg-blue-100 px-3 py-1.5 text-xs font-medium text-blue-700 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Resend
                    </x-gold-button>
                    @endif
                </div>
                @if ($verificationTimeRemaining > 0)
                <div class="mt-2 text-xs text-gray-500">Code expires in
                    {{ $verificationTimeRemaining }} minutes.
                </div>
                @endif
                @endif
                @error('verification_code_input')
                <span class="mt-1 text-xs text-red-600">{{ $message }}</span>
                @enderror
                @else
                <div class="inline-flex items-center text-sm font-medium text-green-600">
                    <svg class="mr-1.5 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                    Email verified!
                </div>
                @endif
            </div>
        </div>
        @endif

        <!-- Navigation Buttons -->
        <div class="flex items-center justify-between pt-6 mt-10 border-t border-gray-200">
            <button wire:click="previousStep" @if ($currentStep===1) disabled @endif
                class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Previous
            </button>
            @if ($currentStep < $totalSteps)
                <button wire:click="nextStep"
                class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-yellow-600 border border-transparent rounded-lg shadow-sm hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2"
                wire:loading.attr="disabled">
                Next
                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                    </path>
                </svg>
                </button>
                @else
                <button wire:click="submitRegistration"
                    class="inline-flex items-center px-6 py-2 text-sm font-medium text-white bg-yellow-600 border border-transparent rounded-lg shadow-sm hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2"
                    wire:loading.attr="disabled">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                        </path>
                    </svg>
                    Submit
                </button>
                @endif
        </div>

        <!-- Feedback Messages -->
        @if (session()->has('success'))
        <div class="px-4 py-3 mt-6 text-sm text-green-700 border border-green-200 rounded-lg bg-green-50">
            {{ session('success') }}
        </div>
        @endif
        @if (session()->has('error'))
        <div class="px-4 py-3 mt-6 text-sm text-red-700 border border-red-200 rounded-lg bg-red-50">
            {{ session('error') }}
        </div>
        @endif
    </div>
</div>
