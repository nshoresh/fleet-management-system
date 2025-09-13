<div>
    <h2 class="text-2xl text-center"><span class="font-semibold text-gray-600">Users :</span>
        <span class="font-bold text-yellow-600">{{ $user_count }}</span>
    </h2>
    <a href="{{ route('admin.vehicle-owners.users', $vehicle_owner->uuid) }}" wire:navigate
        class="text-center text-yellow-500 hover:text-yellow-800">
        View Users
    </a>
</div>
