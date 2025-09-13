<div class="mx-auto max-w-12xl sm:px-6 lg:px-8 ">
    @if (auth()->user()->isAdmin())
        <livewire:system.analytics.dashboard.dasboard-main />
    @else
        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <livewire:client.dashboard.client-dashboard lazy />
            </div>
        </div>
    @endif
</div>
