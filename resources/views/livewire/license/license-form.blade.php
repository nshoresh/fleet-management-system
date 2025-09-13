<div>
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-md-6">
                <h1 class="h3 mb-0 text-gray-800">Create New License</h1>
            </div>
            <div class="col-md-6 text-right">
                <a href="{{ route('license.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Licenses
                </a>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">License Details</h6>
            </div>
            <div class="card-body">
                <form wire:submit.prevent="saveLicense">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="licenseApplicationId">License Application <span class="text-danger">*</span></label>
                            <select id="licenseApplicationId" class="form-control @error('licenseApplicationId') is-invalid @enderror" 
                                wire:model="licenseApplicationId" required>
                                <option value="">-- Select License Application --</option>
                                @foreach($licenseApplications as $application)
                                    <option value="{{ $application->id }}">
                                        APP-{{ $application->id }} | {{ $application->vehicleOwner ? $application->vehicleOwner->name : 'N/A' }} 
                                        | {{ $application->vehicle ? $application->vehicle->plate_number : 'N/A' }}
                                    </option>
                                @endforeach
                            </select>
                            @error('licenseApplicationId')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @if(count($licenseApplications) === 0)
                                <small class="text-danger">No approved license applications found. Approve an application first.</small>
                            @endif
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="registrationNumber">Registration Number <span class="text-danger">*</span></label>
                            <input type="text" id="registrationNumber" class="form-control @error('registrationNumber') is-invalid @enderror" 
                                wire:model="registrationNumber" required>
                            @error('registrationNumber')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="vehicleOwnerId">Vehicle Owner</label>
                            <select id="vehicleOwnerId" class="form-control @error('vehicleOwnerId') is-invalid @enderror" 
                                wire:model="vehicleOwnerId">
                                <option value="">-- Select Vehicle Owner --</option>
                                @foreach($vehicleOwners as $owner)
                                    <option value="{{ $owner->id }}">{{ $owner->name }}</option>
                                @endforeach
                            </select>
                            @error('vehicleOwnerId')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="vehicleId">Vehicle</label>
                            <select id="vehicleId" class="form-control @error('vehicleId') is-invalid @enderror" 
                                wire:model="vehicleId">
                                <option value="">-- Select Vehicle --</option>
                                @foreach($vehicles as $vehicle)
                                    <option value="{{ $vehicle->id }}">
                                        {{ $vehicle->plate_number }} - {{ $vehicle->make }} {{ $vehicle->model }}
                                    </option>
                                @endforeach
                            </select>
                            @error('vehicleId')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label for="licenseTypeId">License Type</label>
                            <select id="licenseTypeId" class="form-control @error('licenseTypeId') is-invalid @enderror" 
                                wire:model="licenseTypeId">
                                <option value="">-- Select License Type --</option>
                                @foreach($licenseTypes as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                            @error('licenseTypeId')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="licensePurposeId">License Purpose</label>
                            <select id="licensePurposeId" class="form-control @error('licensePurposeId') is-invalid @enderror" 
                                wire:model="licensePurposeId">
                                <option value="">-- Select Purpose --</option>
                                @foreach($licensePurposes as $purpose)
                                    <option value="{{ $purpose->id }}">{{ $purpose->name }}</option>
                                @endforeach
                            </select>
                            @error('licensePurposeId')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="routeId">Route</label>
                            <select id="routeId" class="form-control @error('routeId') is-invalid @enderror" 
                                wire:model="routeId">
                                <option value="">-- Select Route --</option>
                                @foreach($routes as $route)
                                    <option value="{{ $route->id }}">{{ $route->name }}</option>
                                @endforeach
                            </select>
                            @error('routeId')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label for="licenseStartDate">Start Date <span class="text-danger">*</span></label>
                            <input type="date" id="licenseStartDate" class="form-control @error('licenseStartDate') is-invalid @enderror" 
                                wire:model="licenseStartDate" required>
                            @error('licenseStartDate')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="licenseEndDate">End Date <span class="text-danger">*</span></label>
                            <input type="date" id="licenseEndDate" class="form-control @error('licenseEndDate') is-invalid @enderror" 
                                wire:model="licenseEndDate" required>
                            @error('licenseEndDate')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="licenseStatus">Status <span class="text-danger">*</span></label>
                            <select id="licenseStatus" class="form-control @error('licenseStatus') is-invalid @enderror" 
                                wire:model="licenseStatus" required>
                                <option value="Active">Active</option>
                                <option value="Expired">Expired</option>
                            </select>
                            @error('licenseStatus')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12 text-right">
                            <button type="button" class="btn btn-secondary mr-2" wire:click="resetForm">
                                <i class="fas fa-redo"></i> Reset
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Create License
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        window.addEventListener('livewire:initialized', () => {
            Livewire.on('alert', (data) => {
                toastr[data.type](data.message);
            });
        });
    </script>
    @endpush
</div>