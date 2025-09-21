<header 
    class="sticky top-0 z-50 border-b border-gray-200 shadow-sm pt-2 pb-2
           bg-gradient-to-r from-yellow-300 via-yellow-500 to-yellow-600"
    x-bind:class="sidebarCollapsed ? 'ml-0' : 'ml-50'"
>
    <div class="px-8">
        <div class="flex items-center justify-between h-16">
            <!-- MIS Name -->
            <h1 class="text-xl font-bold text-gray-900 text-center">
                Fleet Management System
            </h1>
            <!-- Optional Right-side Actions -->
            <!-- Right-side: Current User & Role -->
            <div class="flex items-center space-x-4">
                <span class="text-sm text-gray-800 font-medium">
                    👤 {{ Auth::user()->name }}
                </span>
                <span class="text-sm text-gray-700">
                    ({{ ucfirst(Auth::user()->user_type->slug ?? 'User') }})
                </span>
            </div>
        </div>
    </div>
</header>
