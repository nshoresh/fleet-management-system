<div>
    {{-- The Master doesn't talk, he acts. --}}
    <p>License Number: {{ $license->application_number }}</p>
    <p>Vehicle: {{ $license->vehicle->license_plate }}</p>
    <p>Status: {{ $license->status }}</p>
</div>
