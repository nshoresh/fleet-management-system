<div>
    @if (session()->has('success'))
        <div class="relative px-4 py-3 text-green-700 bg-green-100 border border-green-400 rounded" role="alert">
            <strong class="font-bold">Success!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
            <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                <svg class="w-6 h-6 text-green-500 fill-current" role="button" xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20">
                    <title>CLose</title>
                    <path
                        d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z">
                    </path>
                </svg>
        </div>
</div>
@endif

@if (session()->has('error'))
    <div class="relative px-4 py-3 text-red-700 bg-red-100 border border-red-400 rounded" role="alert">
        <strong class="font-bold">Error!</strong>
        <span class
        ="block sm:inline">{{ session('error') }}</span>
        <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
            <svg class="w-6 h-6 text-red-500 fill-current" role="button" xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 currency12 12">
                <title></title>
                <path
                    d="M10.9 1.6L8.3 4.2 5.7.6.6 4.7l3.6 3.6L.6 11.3l4.1 4.1 3.6-3.6 3.6 3.6 4.1-4.1-3.6-3.6 3.6-3.6z">
                </path>
            </svg>
    </div>
    </div>
@endif
<form wire:submit.prevent="updateUser">
    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
        <!-- User Name -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
            <input wire:model="name" type="text" id="name"
                class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
            @error('name')
                <span class="text-xs text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input wire:model="email" type="email" id="email"
                class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
            @error('email')
                <span class="text-xs text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <!-- Phone -->
        <div>
            <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
            <input wire:model="phone" type="text" id="phone"
                class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
            @error('phone')
                <span class="text-xs text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <!-- Role -->
        <div>
            <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
            <select wire:model="role" id="role"
                class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                <option value="">Select Role</option>
                @foreach ($roles as $roleItem)
                    <option value="{{ $roleItem->id }}">{{ $roleItem->name }}</option>
                @endforeach
            </select>
            @error('role')
                <span class="text-xs text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <!-- User Type -->
        <div>
            <label for="user_type" class="block text-sm font-medium text-gray-700">User Type</label>
            <select wire:model="user_type" id="user_type"
                class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                <option value="">Select User Type</option>
                @foreach ($userTypes as $type)
                    <option value="{{ $type->id }}">{{ $type->type_name }}</option>
                @endforeach
            </select>
            @error('user_type')
                <span class="text-xs text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <!-- Account Status -->
        <div>
            <label for="account_status" class="block text-sm font-medium text-gray-700">Account
                Status</label>
            <select wire:model="account_status" id="account_status"
                class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                <option value="">Select Status</option>
                @foreach ($accountStatus as $status)
                    <option value="{{ $status->id }}">{{ $status->status }}</option>
                @endforeach
            </select>
            @error('account_status')
                <span class="text-xs text-red-500">{{ $message }}</span>
            @enderror
        </div>
        {{-- Checkbox to enable password change --}}



    </div>
    <div>
        <label for="account_status" class="block text-sm font-medium text-gray-700">Change
            Password?</label>
        <input wire:model.live.debounce.300ms="changePassword" type="checkbox" id="changePassword"
            :key="$changePassword" wire:change='updateChangePassword()'>
        <!--
                Vehicle Owner -->

    </div>
    <div>
        @if ($changePassword)
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <input type="password" wire:model="password" id="password"
                class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" />
        @endif
    </div>
    <div class="flex justify-end mt-6 space-x-3">
        <div class="block">

        </div>
        <x-gold-button type="submit"
            class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            Update User
        </x-gold-button>
    </div>
</form>
</div>
