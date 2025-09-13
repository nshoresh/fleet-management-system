<div class="mt-2">
    <form wire:submit.prevent="saveMake" class="space-y-4">
        <div>
            <x-input-label for="name" value="Make Name" />
            <x-text-input wire:model="name" id="name" class="block w-full mt-1" type="text"
                placeholder="Toyota, Ford, Honda, etc." required />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="country" value="Country of Origin" />
            <x-text-input wire:model="country" id="country" class="block w-full mt-1" type="text"
                placeholder="Japan, USA, Germany, etc." />
            <x-input-error :messages="$errors->get('country')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="description" value="Description" />
            <textarea wire:model.live="description" id="description" rows="3"
                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                placeholder="Additional information about this vehicle make..."></textarea>
            <x-input-error :messages="$errors->get('description')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-secondary-button
                type="button" 
                wire:click="resetForm" 
                wire:loading.attr="disabled"
                class="mr-3"
            >
                Cancel
            </x-secondary-button>
            
            <x-primary-button type="submit" wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="saveMake">Create</span>
                <span wire:loading wire:target="saveMake">Saving...</span>
            </x-primary-button>
        </div>
    </form>
</div>
