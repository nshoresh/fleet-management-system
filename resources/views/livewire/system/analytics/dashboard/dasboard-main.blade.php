<div>
    <div>
        <livewire:system.analytics.dashboard.general-stats-cards lazy />
    </div>
    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
        <div>
            <livewire:system.analytics.dashboard.vehicle-makes-stats />
        </div>
        <div>
            <livewire:system.analytics.dashboard.vehicle-types-stats />
        </div>
    </div>
    <div class="mb-4">
        <livewire:system.analytics.dashboard.clients-stats />
    </div>
    {{-- <div class="mb-4">
        <livewire:system.analytics.dashboard.licenses-stats lazy />
    </div> --}}
</div>
