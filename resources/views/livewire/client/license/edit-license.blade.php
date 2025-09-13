<div class="max-w-3xl mx-auto">
    <h2 class="text-xl font-bold mb-4">Edit License</h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit.prevent="save" class="space-y-4">

        <div>
            <label class="block font-medium">Application Number</label>
            <input type="text" wire:model="license.application_number" class="w-full border rounded p-2">
            @error('license.application_number') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block font-medium">Submission Date</label>
            <input type="date" wire:model="license.submission_date" class="w-full border rounded p-2">
            @error('license.submission_date') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block font-medium">Expiry Date</label>
            <input type="date" wire:model="license.expiry_date" class="w-full border rounded p-2">
            @error('license.expiry_date') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block font-medium">Purpose</label>
            <textarea wire:model="license.purpose" class="w-full border rounded p-2"></textarea>
            @error('license.purpose') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block font-medium">Additional Information</label>
            <textarea wire:model="license.additional_information" class="w-full border rounded p-2"></textarea>
            @error('license.additional_information') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <div class="flex items-center space-x-2">
            <input type="checkbox" wire:model="license.terms_accepted">
            <label>I accept the terms</label>
        </div>
        @error('license.terms_accepted') <span class="text-red-500">{{ $message }}</span> @enderror

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
            Save Changes
        </button>
    </form>
</div>
