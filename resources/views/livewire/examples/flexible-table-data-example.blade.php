<div>
    @if (session()->has('message'))
        <div class="relative px-4 py-3 mb-4 text-green-700 bg-green-100 border border-green-400 rounded" role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
            <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                <svg class="w-6 h-6 text-green-500 fill-current" role="button" xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20">
                    <title>Close</title>
                    <path
                        d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" />
                </svg>
            </span>
        </div>
    @endif

    <!-- Render the flexible table component with our data -->
    @livewire('tables.flexible-table', [
        'data' => $tableData,
        'columns' => $tableColumns,
        'tableTitle' => 'User Management',
        'perPage' => 15,
    ])

    <!-- Add event listeners for the table component events -->
    <script>
        document.addEventListener('livewire:load', function() {
            Livewire.on('editItem', function(userId) {
                // Call the editUser method on the parent component
                @this.call('editUser', userId);
            });

            Livewire.on('deleteItem', function(userId) {
                // Confirm before deletion
                if (confirm('Are you sure you want to delete this user?')) {
                    // Call the deleteUser method on the parent component
                    @this.call('deleteUser', userId);
                }
            });
        });
    </script>
</div>
