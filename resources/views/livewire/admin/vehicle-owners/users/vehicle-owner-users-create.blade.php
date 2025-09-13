<div>
    @if (session()->has('success'))
        <div class="bg-green-200 text-green-600 p-3 rounded-md ">
            <p>
                {{ session('success') }}
            </p>
        </div>
    @if (session()->has('error'))
        <div class="p-3 mb-4 text-red-800 bg-red-100 rounded">
            {{ session('error') }}
        </div>
    @endif
    @endif
    <form wire:submit.prevent="store">
        @csrf
        <div class="mb-6">
            <label for="name" class="block mb-2 text-sm font-medium">Name</label>
            <input id="name" wire:model="name" type="text"
                class="block w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-yellow-500 focus:border-yellow-500 "
                required>
            @error('name')
                <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-6">
            <label for="email" class="block mb-2 text-sm font-medium text-gray-90">Email</label>
            <input id="email" wire:model.live.debounce.500ms="email" type="email"
                class="block w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-yellow-500 focus:border-yellow-500 "
                required>
            @error('email')
                <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-6">
            <label for="phone" class="block mb-2 text-sm font-medium text-gray-900">Phone</label>
            <input id="phone" wire:model.live.debounce.500ms="phone" type="text"
                class="block w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-yellow-500 focus:border-yellow-500"
                required>
            @error('phone')
                <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-6">
            <label for="password" class="block mb-2 text-sm font-medium text-gray-900 ">
                Password
            </label>
            <input id="password" wire:model="password" type="password"
                class="block w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-yellow-500 focus:border-yellow-500"
                required>
            @error('password')
                <div class="mt-2 text-sm text-red-600">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <!-- Role ID -->
        <div class="mb-6">
            <label for="role_id" class="block mb-2 text-sm font-medium text-gray-900 ">Role
            </label>
            <select id="role_id" wire:model="role_id"
                class="block w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-yellow-500 focus:border-yellow-500 ">
                <option value="">Select Role</option>
                @foreach ($nonSystemUsers as $role)
                    <option value="{{ $role->id }}">
                        {{ $role->name }}
                    </option>
                @endforeach
            </select>
            @error('role_id')
                <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
            @enderror
        </div>

        <!-- User Type ID -->
        {{-- <div class="mb-6">
            <label for="user_type_id" class="block mb-2 text-sm font-medium text-gray-900 ">
                User Type ID
            </label>
            <select id="user_type_id" wire:model="user_type_id"
                class="block w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-yellow-500 focus:border-yellow-500">
                <option value="">Select User Type</option>
                @foreach (\App\Models\UserType::all() as $user_type)
                    <option value="{{ $user_type->id }}">{{ $user_type->name }}</option>
                @endforeach
            </select>
            @error('user_type_id')
                <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
            @enderror
        </div> --}}
        <!-- Account Status ID -->
        <div class="mb-6">
            <label for="account_status_id" class="block mb-2 text-sm font-medium text-gray-900 ">
                Account Status
            </label>
            <select id="account_status_id" wire:model="account_status_id"
                class="block w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-yellow-500 focus:border-yellow-500">
                <option value="">Select Account Status</option>
                @foreach (\App\Models\AccountStatus::all() as $account_status)
                    <option value="{{ $account_status->id }}">{{ $account_status->status }}</option>
                @endforeach
            </select>
            @error('account_status_id')
                <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
            @enderror
        </div>
        <x-gold-button type="submit">
            Register
        </x-gold-button>
        <button @click="closeModal()" type="button"
            class="inline-flex justify-center w-full px-4 py-2 mt-3 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm">
           Cancel
        </button>
    </form>
    @if (session()->has('success'))
        <div class="mt-4 text-sm text-green-600">{{ session('success') }}</div>
    @endif
</div>