<div class="mx-auto max-w-12xl sm:px-6 lg:px-8 bg-white shadow-md rounded-2xl">
    @if (session()->has('message'))
        <div class="p-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="p-4 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">
            {{ session('error') }}
        </div>
    @endif
    <div class="p-8 text-gray-900">
        <form class="space-y-6" wire:submit.prevent="registerUser">
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
                <x-gold-text-input type="email" wire:model.live.debounce.300ms="email" id="email" required />
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
                <x-gold-text-input type="password" wire:model="password_confirmation" id="password_confirmation"
                    required />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-500" />
            </div>
            <hr />

            <!-- Role -->
            <div class="flex items-center space-x-4">
                <label for="role_id" class="w-32 text-sm font-medium text-gray-700">Role</label>
                <select wire.model.debounce.300ms="role_id" id="role_id" required
                    class="block w-full pl-10 border-gray-300 rounded-sm shadow-sm focus:border-yellow-500 focus:ring-yellow-500 sm:text-sm">
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>
            <hr />

            <!-- Account Status -->
            <div class="flex items-center space-x-4">
                <label for="account_status_id" class="w-32 text-sm font-medium text-gray-700">Account Status</label>
                <select wire:model.live.debounce.300ms="account_status_id" id="account_status_id" required
                    class="block w-full pl-10 border-gray-300 rounded-sm shadow-sm focus:border-yellow-500 focus:ring-yellow-500 sm:text-sm">
                    @foreach ($account_statuses as $status)
                        <option value="{{ $status->id }}">{{ $status->id }}: {{ $status->status }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('account_status_id')" class="mt-2 text-red-500" />
            </div>
            <hr />

            <!-- Submit Button -->
            <div>
                <x-gold-button type="submit">
                    Register
                </x-gold-button>
            </div>
        </form>
    </div>
</div>
