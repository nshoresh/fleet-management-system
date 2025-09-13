<div>
    <h2 class="text-2xl text-center"><span class="font-semibold text-gray-600">Fleets :</span>
        <span class="font-bold text-yellow-600">{{ $vehicle_count }}</span>
    </h2>

    <a href="{{ route('admin.vehicle-owners.fleets', $vehicle_owner->uuid) }}" wire:navigate
        class="text-center text-yellow-500 hover:text-yellow-800">
        View Fleets
    </a>
</div>
