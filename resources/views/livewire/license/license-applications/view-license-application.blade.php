<div class="p-6 bg-gray-50 min-h-screen">
    {{-- Page Title --}}
    <h1 class="text-3xl font-bold text-gray-900 mb-6 p-4 rounded-lg shadow 
               bg-gradient-to-r from-gray-100 via-gray-300 to-gray-600">
        Review License Application
    </h1>

    {{-- Flash Message --}}
    @if (session()->has('success'))
        <div class="mb-4 p-4 rounded-lg bg-green-100 text-green-700 border border-green-300">
            {{ session('success') }}
        </div>
    @endif

    {{-- Application Details --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- Vehicle Information --}}
        <div class="bg-white shadow rounded-xl overflow-hidden">
            <div class="bg-gradient-to-r from-gray-100 via-gray-300 to-gray-200 text-gray-900 px-4 py-2 font-semibold">🚘 Vehicle Information</div>
            <div class="p-6">
                <dl class="grid grid-cols-3 gap-2 text-sm">
                    <dt class="font-medium col-span-1">Vehicle:</dt>
                    <dd class="col-span-2">{{ $application->vehicle->makeType->name ?? 'N/A' }}</dd>

                    <dt class="font-medium col-span-1">License Plate:</dt>
                    <dd class="col-span-2">{{ $application->vehicle->license_plate ?? 'N/A' }}</dd>

                    <dt class="font-medium col-span-1">VIN:</dt>
                    <dd class="col-span-2">{{ $application->vehicle->vin ?? 'N/A' }}</dd>

                    <dt class="font-medium col-span-1">Make:</dt>
                    <dd class="col-span-2">{{ $application->vehicle->make?->name ?? 'N/A' }}</dd>

                    <dt class="font-medium col-span-1">Model:</dt>
                    <dd class="col-span-2">{{ $application->vehicle->makeModel?->name ?? 'N/A' }}</dd>

                    <dt class="font-medium col-span-1">Year:</dt>
                    <dd class="col-span-2">{{ $application->vehicle->year ?? 'N/A' }}</dd>
                </dl>
            </div>
        </div>

        {{-- Owner Information --}}
        <div class="bg-white shadow rounded-xl overflow-hidden">
            <div class="bg-gradient-to-r from-gray-100 via-gray-300 to-gray-200 text-gray-900 px-4 py-2 font-semibold">👤 Vehicle Owner Information</div>
            <div class="p-6">
                <dl class="grid grid-cols-3 gap-2 text-sm">
                    <dt class="font-medium col-span-1">Owner Name:</dt>
                    <dd class="col-span-2">{{ $application->vehicle->vehicleOwner->name ?? 'N/A' }}</dd>

                    <dt class="font-medium col-span-1">Email:</dt>
                    <dd class="col-span-2">{{ $application->vehicle->vehicleOwner->email ?? 'N/A' }}</dd>

                    <dt class="font-medium col-span-1">Phone:</dt>
                    <dd class="col-span-2">{{ $application->vehicle->vehicleOwner->contact_number ?? 'N/A' }}</dd>

                    <dt class="font-medium col-span-1">Address:</dt>
                    <dd class="col-span-2">{{ $application->vehicle->vehicleOwner->address ?? 'N/A' }}</dd>
                </dl>
            </div>
        </div>
    </div>

    {{-- Application Information --}}
    <div class="bg-white shadow rounded-xl mt-6 overflow-hidden">
        <div class="bg-gradient-to-r from-gray-100 via-gray-300 to-gray-200 text-gray-900 px-4 py-2 font-semibold">📄 Application Information</div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <p><span class="font-medium">Application No:</span> {{ $application->application_number }}</p>
                <p><span class="font-medium">License Type:</span> {{ $application->licenseType?->type_name ?? 'N/A' }}</p>
                <p><span class="font-medium">Submission Date:</span> {{ $application->submission_date }}</p>
                <p><span class="font-medium">Expiry Date:</span> {{ $application->expiry_date ?? 'N/A' }}</p>
                <p><span class="font-medium">Purpose:</span> {{ $application->purpose ?? 'N/A' }}</p>
                <p>
                    <span class="font-medium">Status:</span>
                    <span class="px-2 py-1 text-xs rounded-lg 
                        {{ $application->status === 'Pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-green-100 text-green-700' }}">
                        {{ $application->status }}
                    </span>
                </p>
            </div>
        </div>
    </div>

    {{-- Application Notes --}}
    <div class="bg-white shadow rounded-xl mt-6 overflow-hidden">
        <div class="bg-gradient-to-r from-gray-100 via-gray-300 to-gray-200 text-gray-900 px-4 py-2 font-semibold">📝 Additional Information</div>
        <div class="p-6">
            <p class="text-sm">{{ $application->additional_information ?? 'N/A' }}</p>
        </div>
    </div>

    {{-- Supporting Documents --}}
    <div class="bg-white shadow rounded-xl mt-6 overflow-hidden">
        <div class="bg-gradient-to-r from-gray-100 via-gray-300 to-gray-200 text-gray-900 px-4 py-2 font-semibold">📎 Supporting Documents</div>
        <div class="p-6">
            @if($application->documents && $application->documents->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($application->documents as $doc)
                        <div class="border rounded-lg p-4 flex items-center justify-between hover:shadow">
                            <div class="flex items-center space-x-2">
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" stroke-width="2"
                                     viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M15.172 7l-6.586 6.586a2 2 0 002.828 2.828L18 9.828V7h-2.828z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M16 5a2 2 0 012 2v5.586a2 2 0 01-.586 1.414l-4.828 4.828a4 4 0 11-5.656-5.656L13.172 7H16z"/>
                                </svg>
                                <span class="text-sm text-gray-700 truncate">{{ basename($doc->file_path) }}</span>
                            </div>
                            <a href="{{ $doc->url }}" target="_blank"
                               class="px-3 py-1 bg-gradient-to-r from-yellow-300 via-yellow-500 to-yellow-600 
                                      text-white text-xs rounded hover:opacity-90">
                                View
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-sm">No supporting documents uploaded.</p>
            @endif
        </div>
    </div>

    {{-- Actions --}}
    <div class="mt-8 flex items-center gap-4">
        <a href="{{ route('license.create', ['applicationId' => $application->id]) }}"
           class="px-6 py-2 rounded-lg shadow text-white
                  bg-gradient-to-r from-yellow-300 via-yellow-500 to-yellow-600 hover:opacity-90">
            Create License
        </a>
        <a href="{{ route('admin.license.applications') }}"
           class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg shadow hover:bg-gray-300">
            Back to Applications
        </a>
    </div>
</div>
