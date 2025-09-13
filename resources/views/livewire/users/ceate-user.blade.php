<div>
    <h2 class="text-2xl">User Registration</h2>

    @if (session()->has('message'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
            class="fixed top-4 right-4 px-4 py-3 text-green-700 bg-green-100 border border-green-400 rounded shadow-lg z-50 max-w-sm"
            role="alert">
            <div class="flex items-center justify-between">
                <span class="block">{{ session('message') }}</span>
                <button @click="show = false" class="ml-4 text-green-700 hover:text-green-900">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    @endif

    @if (session()->has('error'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 10000)"
            class="fixed top-4 right-4 px-4 py-3 text-red-700 bg-red-100 border border-red-400 rounded shadow-lg z-50 max-w-sm"
            role="alert">
            <div class="flex items-center justify-between">
                <span class="block">{{ session('error') }}</span>
                <button @click="show = false" class="ml-4 text-red-700 hover:text-green-900">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    @endif
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white rounded-lg shadow-lg">
                <div class="p-8 text-gray-900">
                    <form class="space-y-6" wire:submit.prevent="register">
                        @csrf

                        <!-- Name -->
                        <div class="flex items-center space-x-4">
                            <label for="name" class="w-32 text-sm font-medium text-gray-700">Name</label>
                            <x-gold-text-input type="text" wire:model="name" id="name" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-500" />
                        </div>
                        <hr />
                        <!-- Email -->
                        <div class="flex items-center space-x-4">
                            <label for="email" class="w-32 text-sm font-medium text-gray-700">Email</label>
                            <x-gold-text-input type="email" wire:model.live.debounce.300ms="email" id="email"
                                required />
                            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500" />
                        </div>
                        <hr />
                        <!-- Phone -->
                        <div class="flex items-center space-x-4">
                            <label for="phone" class="w-32 text-sm font-medium text-gray-700">Phone</label>
                            <x-gold-text-input type="text" wire:model="phone" id="phone" required />
                            <x-input-error :messages="$errors->get('phone')" class="mt-2 text-red-500" />
                        </div>
                        <hr />
                        <!-- Password -->
                        <div class="flex items-center space-x-4">
                            <label for="password" class="w-32 text-sm font-medium text-gray-700">Password</label>
                            <x-gold-text-input type="password" wire:model="password" id="password" required />
                            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500" />
                        </div>
                        <hr />
                        <!-- Confirm Password -->
                        <div class="flex items-center space-x-4">
                            <label for="password_confirmation" class="w-32 text-sm font-medium text-gray-700">Confirm
                                Password</label>
                            <x-gold-text-input type="password" wire:model="password_confirmation"
                                id="password_confirmation" required />
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-500" />
                        </div>
                        <hr />
                        <div class="flex items-center space-x-4">
                            <label for="role_id" class="w-32 text-sm font-medium text-gray-700">User Type</label>
                            <select wire:model.live.debounce.300ms="user_type_id" id="user_type_id"
                                wire:change='$this->updatedUserTypeId()' required
                                class="block w-full pl-10 border-gray-300 rounded-sm shadow-sm focus:border-yellow-500 focus:ring-yellow-500 sm:text-sm">
                                @foreach ($user_types as $user_type)
                                    <option value="{{ $user_type->id }}">{{ $user_type->type_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <hr />
                        <!-- Role -->
                        <div class="flex items-center space-x-4">
                            <label for="role_id" class="w-32 text-sm font-medium text-gray-700">Role</label>
                            <select wire:model="role_id" id="role_id" required
                                class="block w-full pl-10 border-gray-300 rounded-sm shadow-sm focus:border-yellow-500 focus:ring-yellow-500 sm:text-sm"
                                @if (!$user_type_id) disabled @endif>
                                <option value="">Select a role</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <hr />
                        <!-- Account Status -->
                        <div class="flex items-center space-x-4">
                            <label for="account_status_id" class="w-32 text-sm font-medium text-gray-700">Account
                                Status</label>
                            <select wire:model="account_status_id" id="account_status_id" required
                                class="block w-full pl-10 border-gray-300 rounded-sm shadow-sm focus:border-yellow-500 focus:ring-yellow-500 sm:text-sm">
                                @foreach ($account_statuses as $status)
                                    <option value="{{ $status->id }}">{{ $status->status }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('account_status_id')" class="mt-2 text-red-500" />
                        </div>
                        <hr />
                        <!-- Submit Button -->
                        <div>
                            <x-gold-button
                                class="px-4 py-2 text-lg font-semibold text-white bg-indigo-600 rounded-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                Register
                            </x-gold-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        window.addEventListener('swal', event => {
            Swal.fire({
                icon: event.detail.type,
                title: event.detail.message,
                showConfirmButton: true
            });
        });
    </script>
@endpush
