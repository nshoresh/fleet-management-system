<div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8 py-8">
    <!-- Main Card Container -->
    <div class="overflow-hidden bg-white shadow-xl rounded-lg">
        <!-- Flash message with improved styling -->
        <div class="mb-4">
            @if (session()->has('message'))
                <div class="p-4 bg-green-50 border-l-4 border-green-500"
                    x-data="{ show: true, timeLeft: 5 }"
                    x-init="
                        setTimeout(() => { show = false }, 5000);
                        setInterval(() => { if (timeLeft > 0) timeLeft-- }, 1000);
                    "
                    x-show="show"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:leave="transition ease-in duration-200"
                    >
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <svg class="h-5 w-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <p class="text-sm font-medium text-green-800">{{ session('message') }}</p>
                        </div>
                        <button 
                        @click="show = false"
                        type="button" class="text-green-500 hover:text-green-700 focus:outline-none">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </div>
            @endif
        </div>

        <!-- Header Section -->
        <div class="px-6 py-4 bg-indigo-700">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-white">Vehicle Make Details</h1>
                </div>
                <div>
                    <x-gold-button-link-sm href="{{ route('vehicles.makes') }}" wire:navigate class="bg-white/10 hover:bg-white/20">
                        <x-icons.arrow-left class="w-4 h-4 mr-1" />
                        Back to List
                    </x-gold-button-link-sm>
                </div>
            </div>
        </div>

        <!-- Content Section -->
        <div class="px-6 py-8">
            <!-- Title Section -->
            <div class="mb-8 pb-6 border-b border-gray-200">
                <h2 class="text-3xl font-bold text-gray-900">{{ $make->name }}</h2>
                <p class="mt-1 text-sm text-gray-500">Make ID: {{ $make->id }}</p>
            </div>

            <!-- Details Grid -->
            <div class="grid grid-cols-1 gap-8 md:grid-cols-2">
                <!-- Left Column -->
                <div class="space-y-6">
                    <div>
                        <h3 class="text-xs font-semibold tracking-wider text-gray-500 uppercase">Country of Origin</h3>
                        <p class="mt-2 p-4 text-gray-700 bg-gray-50 rounded-lg shadow-sm">{{ $make->country ?? 'N/A' }}</p>
                    </div>
                    
                    <div>
                        <h3 class="text-xs font-semibold tracking-wider text-gray-500 uppercase">Description</h3>
                        <p class="mt-2 p-4 text-gray-700 bg-gray-50 rounded-lg shadow-sm whitespace-pre-line">{{ $make->description ?? 'No description provided' }}</p>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="space-y-6">
                    <div>
                        <h3 class="text-xs font-semibold tracking-wider text-gray-500 uppercase">Registration Date</h3>
                        <p class="mt-2 p-4 text-gray-700 bg-gray-50 rounded-lg shadow-sm">
                            {{ $make->created_at->format('F d, Y') }}
                        </p>
                    </div>
                    
                    <div>
                        <h3 class="text-xs font-semibold tracking-wider text-gray-500 uppercase">Last Updated</h3>
                        <p class="mt-2 p-4 text-gray-700 bg-gray-50 rounded-lg shadow-sm">
                            {{ $make->updated_at->format('F d, Y \a\t h:i A') }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-12 pt-6 border-t border-gray-200 flex justify-end">
                <x-gold-button-link href="{{ route('vehicles.makes.edit', $make) }}" wire:navigate class="px-6 py-3">
                    <x-icons.pencil-square class="w-5 h-5 mr-2" />
                    Edit Make Details
                </x-gold-button-link>
            </div>
        </div>
    </div>
</div>