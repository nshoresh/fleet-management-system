<div>
    <div>
        <x-slot name="title">
            <div class="flex items-center">
                {{-- <x-icon name="user-plus" class="w-6 h-6 mr-2"></x-icon> --}}
                <span>Register New User</span>
            </div>
        </x-slot>

        <div name="content">
            <!-- Session Flash Message -->
            @if (session()->has('message'))
                <div class="px-4 py-2 mb-4 text-green-800 bg-green-100 rounded">
                    {{ session('message') }}
                </div>
            @endif
            @if (session()->has('error'))
                <div class="px-4 py-2 mb-4 text-red-800 bg-red-100 rounded">
                    {{ session('error') }}
                </div>
            @endif
            <form wire:submit.prevent="register" class="space-y-4">
                <!-- Name Input -->
                <div>
                    <label for="name">Full Name</label>
                    <x-gold-text-input type='text' id="name" type="text" wire:model.debounce.500ms="name"
                        class="block w-full mt-1" required />
                    {{-- <x-input-error for="name" class="mt-1" /> --}}
                </div>
                <!-- Email Input -->
                <div>
                    <label for="email">Email Address</label>
                    <x-gold-text-input type='text' id="email" type="email" wire:model.debounce.500ms="email"
                        class="block w-full mt-1" required />
                    {{-- <x-input-error for="email" class="mt-1" /> --}}
                </div>
                <!-- Phone Input -->
                <div>
                    <label for="phone">Phone Number</label>
                    <x-gold-text-input type='text' id="phone" type="text" wire:model.debounce.500ms="phone"
                        class="block w-full mt-1" required />
                    {{-- <x-input-error for="phone" class="mt-1" /> --}}
                </div>
                <!-- Role Selection -->
                <div>
                    <label for="role_id">User Role</label>
                    <select id="role_id" wire:model="role_id" class="block w-full mt-1">
                        <option value="">-- Select Role --</option>
                        @foreach ($nonSystemUsers as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                    {{-- <x-input-error for="role_id" class="mt-1" /> --}}
                </div>

                <!-- Password Input -->
                <div>
                    <label for="password">Password</label>
                    <x-gold-text-input type='text' id="password" type="password"
                        wire:model.debounce.500ms="password" class="block w-full mt-1" required />
                    {{-- <x-input-error for="password" class="mt-1" /> --}}
                </div>

                <!-- Password Confirmation -->
                <div>
                    <label for="password_confirmation">Confirm Password</label>
                    <x-gold-text-input type='text' id="password_confirmation" type="password"
                        wire:model.debounce.500ms="password_confirmation" class="block w-full mt-1" required />

                </div>

                <!-- Avatar Upload -->
                <div>
                    <label for="avatar" value="Profile Picture (Optional)">Profile Picture (Optional)</label>
                    <div class="flex items-center mt-1">
                        <!-- Preview Image -->
                        @if ($avatar)
                            <div class="mr-3">
                                <img src="{{ $avatar->temporaryUrl() }}" class="object-cover w-16 h-16 rounded-full">
                            </div>
                        @endif

                        <label
                            class="px-3 py-2 text-sm font-medium leading-4 text-gray-700 border border-gray-300 rounded-md cursor-pointer hover:bg-gray-50">
                            Choose File
                            <input type="file" wire:model="avatar" class="hidden" accept="image/*">
                        </label>
                    </div>
                    <div wire:loading wire:target="avatar" class="mt-1 text-sm text-gray-500">
                        Uploading...
                    </div>

                </div>

                <!-- Vehicle Owner Info (Optional display) -->
                <div class="p-3 rounded-md bg-gray-50">
                    <p class="text-sm text-gray-700">
                        <span class="font-medium">Registering for:</span> {{ $vehicleOwner->name }}
                    </p>
                </div>

                <div class="flex justify-end mt-6 space-x-3">

                    <x-gold-button type="submit" class="bg-blue-600 hover:bg-blue-700">
                        <span wire:loading.remove wire:target="register">Register User</span>
                        <span wire:loading wire:target="register">Processing...</span>
                    </x-gold-button>
                </div>
            </form>
        </div>
    </div>
</div>
