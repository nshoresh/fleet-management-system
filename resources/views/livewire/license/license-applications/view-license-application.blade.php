<div class="p-6 bg-gray-50 min-h-screen">
    {{-- Page Title --}}
    <h1 class="text-2xl font-bold text-gray-800 mb-6">
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
        <div class="bg-white shadow rounded-xl p-6">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">Vehicle Information</h2>
            <div class="space-y-2 text-sm">
                <p><span class="font-medium">Vehicle:</span> {{ $application->vehicle->makeType->name ?? 'N/A' }}</p>
                <p><span class="font-medium">License Plate:</span> {{ $application->vehicle->license_plate ?? 'N/A' }}</p>
                <p><span class="font-medium">VIN:</span> {{ $application->vehicle->vin ?? 'N/A' }}</p>
                <p><span class="font-medium">Make:</span> {{ $application->vehicle->make?->name ?? 'N/A' }}</p>
                <p><span class="font-medium">Model:</span> {{ $application->vehicle->makeModel?->name ?? 'N/A' }}</p>
                <p><span class="font-medium">Year:</span> {{ $application->vehicle->year ?? 'N/A' }}</p>
            </div>
        </div>

        {{-- Owner Information --}}
        <div class="bg-white shadow rounded-xl p-6">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">Vehicle Owner Information</h2>
            <div class="space-y-2 text-sm">
                <p><span class="font-medium">Owner Name:</span> {{ $application->vehicle->vehicleOwner->name ?? 'N/A' }}</p>
                <p><span class="font-medium">Email:</span> {{ $application->vehicle->vehicleOwner->email ?? 'N/A' }}</p>
                <p><span class="font-medium">Phone:</span> {{ $application->vehicle->vehicleOwner->contact_number ?? 'N/A' }}</p>
                <p><span class="font-medium">Address:</span> {{ $application->vehicle->vehicleOwner->address ?? 'N/A' }}</p>
            </div>
        </div>

        {{-- Application Information --}}
        <div class="bg-white shadow rounded-xl p-6 md:col-span-2">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">Application Information</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <p><span class="font-medium">Application No:</span> {{ $application->application_number }}</p>
                <p><span class="font-medium">License Type:</span> {{ $application->licenseType?->type_name ?? 'N/A' }}</p>
                <p><span class="font-medium">Submission Date:</span> {{ $application->submission_date }}</p>
                <p><span class="font-medium">Expiry Date:</span> {{ $application->expiry_date ?? 'N/A' }}</p>
                <p><span class="font-medium">Purpose:</span> {{ $application->purpose ?? 'N/A' }}</p>
                <p><span class="font-medium">Additional Info:</span> {{ $application->additional_information ?? 'N/A' }}</p>
                <p><span class="font-medium">Status:</span> 
                    <span class="px-2 py-1 text-xs rounded-lg 
                        {{ $application->status === 'Pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-green-100 text-green-700' }}">
                        {{ $application->status }}
                    </span>
                </p>
            </div>
        </div>

        {{-- Supporting Documents --}}
        <div class="bg-white shadow rounded-xl p-6 md:col-span-2">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">Supporting Documents</h2>
            @if($application->documents && $application->documents->count() > 0)
                <ul class="list-disc pl-6 text-sm space-y-1">
                    @foreach($application->documents as $doc)
                        <li>
                            <a href="{{ Storage::url($doc->file_path) }}" target="_blank" class="text-blue-600 hover:underline">
                                View Document
                            </a>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-gray-500 text-sm">No supporting documents uploaded.</p>
            @endif
        </div>
    </div>

    {{-- Actions --}}
    <div class="mt-8 flex items-center gap-4">
        <a href="{{ route('license.create', ['applicationId' => $application->id]) }}"
            class="px-6 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700">
            Create License
        </a>
        <a href="{{ route('admin.license.applications') }}"
           class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg shadow hover:bg-gray-300">
            Back to Applications
        </a>
    </div>
</div>

