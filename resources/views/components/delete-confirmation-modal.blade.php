<div class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-50">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md">
        <div class="px-6 py-4">
            <h2 class="text-lg font-semibold text-gray-900">Confirm Delete</h2>
            <p class="mt-2 text-sm text-gray-600">Are you sure you want to delete this item? This action cannot be undone.</p>
        </div>
        <div class="flex justify-end px-6 py-4 space-x-2 bg-gray-50 rounded-b-lg">
            <x-secondary-button wire:click="$set('showDeleteModal', false)">
                Cancel
            </x-secondary-button>
            <x-danger-button wire:click="{{ $action }}">
                Delete
            </x-danger-button>
        </div>
    </div>
</div>
