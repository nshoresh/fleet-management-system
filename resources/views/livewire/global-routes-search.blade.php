<div class="max-w-3xl px-2 py-5 mx-auto">
    <!-- Global Search Bar -->
    <div class="flex mb-4 gp-2">
        <x-gold-text-input-shadowed type="text" wire:model.live.debounce.200ms="search"
            placeholder="Search Modules..." />

        <!-- Clear Button -->
        @if ($search)
            <!-- Only show button if there is a search query -->
            <button wire:click="$set('search', '')"
                class="p-2 ml-2 text-sm text-gray-500 bg-gray-100 rounded-md hover:bg-gray-200 focus:outline-none">
                <x-icons.x-circle />
            </button>
        @endif
    </div>

    <!-- Loading Indicator -->
    <div wire:loading.flex class="absolute z-50 items-center justify-center">
        <x-loading-indicator />
    </div>

    <!-- Search Results -->
    @if ($search)
        <div class="absolute z-50 p-4 bg-white rounded-lg shadow-xl opacity-100">
            @if (strlen($search) < $minSearchLength)
                <div class="p-4 text-center text-gray-500">Please enter at least {{ $minSearchLength }} characters to
                    search</div>
            @else
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    @if ($routes->count() > 0)
                        @foreach ($routes as $route)
                            <div class="p-4 border">
                                <div class="text-sm text-gray-600">
                                    @if ($route->name && Route::has($route->name))
                                        <a href="{{ route($route->name) }}" wire:navigate>
                                            <strong>URI:</strong> {{ $route->uri }} <br>
                                        </a>
                                    @else
                                        <span>
                                            <strong>URI:</strong> {{ $route->uri }} <br>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="col-span-4 p-4 text-center text-gray-500">No results found.</div>
                    @endif
                </div>
            @endif
        </div>
    @endif
</div>
