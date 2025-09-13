<div>
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Add New Vehicle</h5>
        </div>
        <div class="card-body">
            <form wire:submit.prevent="saveVehicle">
                <!-- Form Sections Tabs -->
                <ul class="mb-4 nav nav-tabs" id="vehicle-form-tabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="basic-info-tab" data-bs-toggle="tab"
                            data-bs-target="#basic-info" type="button" role="tab" aria-controls="basic-info"
                            aria-selected="true">Basic Info</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="tech-specs-tab" data-bs-toggle="tab" data-bs-target="#tech-specs"
                            type="button" role="tab" aria-controls="tech-specs" aria-selected="false">Technical
                            Specs</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="financial-tab" data-bs-toggle="tab" data-bs-target="#financial"
                            type="button" role="tab" aria-controls="financial" aria-selected="false">Financial
                            Info</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="photos-tab" data-bs-toggle="tab" data-bs-target="#photos"
                            type="button" role="tab" aria-controls="photos" aria-selected="false">Photos</button>
                    </li>
                </ul>

                <!-- Flash Messages -->
                @if (session()->has('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Tab Content -->
                <div class="tab-content" id="vehicle-form-content">
                    <!-- Basic Info -->
                    <div class="tab-pane fade show active" id="basic-info" role="tabpanel"
                        aria-labelledby="basic-info-tab">
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="vin" class="form-label">VIN <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('vin') is-invalid @enderror"
                                    id="vin" wire:model="vin">
                                @error('vin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="registration_number" class="form-label">Registration Number <span
                                        class="text-danger">*</span></label>
                                <input type="text"
                                    class="form-control @error('registration_number') is-invalid @enderror"
                                    id="registration_number" wire:model="registration_number">
                                @error('registration_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="year" class="form-label">Year <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('year') is-invalid @enderror"
                                    id="year" wire:model="year" min="1900" max="{{ date('Y') + 1 }}">
                                @error('year')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="mileage" class="form-label">Mileage (km) <span
                                        class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('mileage') is-invalid @enderror"
                                    id="mileage" wire:model="mileage" min="0" step="1">
                                @error('mileage')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="vehicle_make_id" class="form-label">Make <span
                                        class="text-danger">*</span></label>
                                <select class="form-select @error('vehicle_make_id') is-invalid @enderror"
                                    id="vehicle_make_id" wire:model="vehicle_make_id">
                                    <option value="">Select Make</option>
                                    @foreach ($makes as $make)
                                        <option value="{{ $make->id }}">{{ $make->name }}</option>
                                    @endforeach
                                </select>
                                @error('vehicle_make_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="vehicle_model_id" class="form-label">Model <span
                                        class="text-danger">*</span></label>
                                <select class="form-select @error('vehicle_model_id') is-invalid @enderror"
                                    id="vehicle_model_id" wire:model="vehicle_model_id"
                                    {{ count($models) ? '' : 'disabled' }}>
                                    <option value="">{{ count($models) ? 'Select Model' : 'Select Make First' }}
                                    </option>
                                    @foreach ($models as $model)
                                        <option value="{{ $model->id }}">{{ $model->name }}</option>
                                    @endforeach
                                </select>
                                @error('vehicle_model_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="vehicle_type_id" class="form-label">Vehicle Type <span
                                        class="text-danger">*</span></label>
                                <select class="form-select @error('vehicle_type_id') is-invalid @enderror"
                                    id="vehicle_type_id" wire:model="vehicle_type_id">
                                    <option value="">Select Type</option>
                                    @foreach ($vehicleTypes as $type)
                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                                @error('vehicle_type_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="vehicle_color_id" class="form-label">Color <span
                                        class="text-danger">*</span></label>
                                <select class="form-select @error('vehicle_color_id') is-invalid @enderror"
                                    id="vehicle_color_id" wire:model="vehicle_color_id">
                                    <option value="">Select Color</option>
                                    @foreach ($colors as $color)
                                        <option value="{{ $color->id }}">{{ $color->name }}</option>
                                    @endforeach
                                </select>
                                @error('vehicle_color_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="engine_number" class="form-label">Engine Number</label>
                                <input type="text"
                                    class="form-control @error('engine_number') is-invalid @enderror"
                                    id="engine_number" wire:model="engine_number">
                                @error('engine_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="chassis_number" class="form-label">Chassis Number</label>
                                <input type="text"
                                    class="form-control @error('chassis_number') is-invalid @enderror"
                                    id="chassis_number" wire:model="chassis_number">
                                @error('chassis_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="mb-3 col-md-12">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" wire:model="description"
                                    rows="3"></textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Technical Specifications -->
                    <div class="tab-pane fade" id="tech-specs" role="tabpanel" aria-labelledby="tech-specs-tab">
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="engine_capacity" class="form-label">Engine Capacity (cc)</label>
                                <input type="number"
                                    class="form-control @error('engine_capacity') is-invalid @enderror"
                                    id="engine_capacity" wire:model="engine_capacity" min="0" step="0.1">
                                @error('engine_capacity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="fuel_type_id" class="form-label">Fuel Type <span
                                        class="text-danger">*</span></label>
                                <select class="form-select @error('fuel_type_id') is-invalid @enderror"
                                    id="fuel_type_id" wire:model="fuel_type_id">
                                    <option value="">Select Fuel Type</option>
                                    @foreach ($fuelTypes as $type)
                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                                @error('fuel_type_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="transmission_type_id" class="form-label">Transmission <span
                                        class="text-danger">*</span></label>
                                <select class="form-select @error('transmission_type_id') is-invalid @enderror"
                                    id="transmission_type_id" wire:model="transmission_type_id">
                                    <option value="">Select Transmission</option>
                                    @foreach ($transmissionTypes as $type)
                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                                @error('transmission_type_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="power" class="form-label">Power (hp)</label>
                                <input type="number" class="form-control @error('power') is-invalid @enderror"
                                    id="power" wire:model="power" min="0" step="0.1">
                                @error('power')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="mb-3 col-md-4">
                                <label for="torque" class="form-label">Torque (Nm)</label>
                                <input type="number" class="form-control @error('torque') is-invalid @enderror"
                                    id="torque" wire:model="torque" min="0" step="0.1">
                                @error('torque')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="seats" class="form-label">Number of Seats</label>
                                <input type="number" class="form-control @error('seats') is-invalid @enderror"
                                    id="seats" wire:model="seats" min="1" max="100">
                                @error('seats')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="doors" class="form-label">Number of Doors</label>
                                <input type="number" class="form-control @error('doors') is-invalid @enderror"
                                    id="doors" wire:model="doors" min="0" max="10">
                                @error('doors')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Financial Info -->
                    <div class="tab-pane fade" id="financial" role="tabpanel" aria-labelledby="financial-tab">
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="purchase_date" class="form-label">Purchase Date</label>
                                <input type="date"
                                    class="form-control @error('purchase_date') is-invalid @enderror"
                                    id="purchase_date" wire:model="purchase_date">
                                @error('purchase_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="status" class="form-label">Status <span
                                        class="text-danger">*</span></label>
                                <select class="form-select @error('status') is-invalid @enderror" id="status"
                                    wire:model="status">
                                    <option value="available">Available</option>
                                    <option value="maintenance">Under Maintenance</option>
                                    <option value="rented">Rented</option>
                                    <option value="sold">Sold</option>
                                    <option value="reserved">Reserved</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="purchase_price" class="form-label">Purchase Price</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number"
                                        class="form-control @error('purchase_price') is-invalid @enderror"
                                        id="purchase_price" wire:model="purchase_price" min="0"
                                        step="0.01">
                                    @error('purchase_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="market_value" class="form-label">Market Value</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number"
                                        class="form-control @error('market_value') is-invalid @enderror"
                                        id="market_value" wire:model="market_value" min="0" step="0.01">
                                    @error('market_value')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Photos -->
                    <div class="tab-pane fade" id="photos" role="tabpanel" aria-labelledby="photos-tab">
                        <div class="mb-3 row">
                            <div class="col-md-12">
                                <label for="photos" class="form-label">Vehicle Photos</label>
                                <input type="file" class="form-control @error('photos.*') is-invalid @enderror"
                                    id="photos" wire:model="photos" multiple accept="image/*">
                                <small class="text-muted">You can upload multiple photos. The first photo will be set
                                    as the primary image.</small>
                                @error('photos.*')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        @if (count($photos) > 0)
                            <div class="row">
                                <div class="col-12">
                                    <h6 class="mb-3">Preview:</h6>
                                </div>
                            </div>
                            <div class="row">
                                @foreach ($photos as $index => $photo)
                                    <div class="mb-3 col-md-3">
                                        <div class="card">
                                            <img src="{{ $photo->temporaryUrl() }}" class="card-img-top"
                                                alt="Vehicle Photo Preview">
                                            <div class="p-2 text-center card-body">
                                                <button type="button" class="btn btn-sm btn-danger"
                                                    wire:click="$set('photos.{{ $index }}', null)">Remove</button>
                                                @if ($index === 0)
                                                    <span class="badge bg-primary ms-2">Primary</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <div class="mt-4 d-flex justify-content-between">
                    <a href="{{ route('vehicles.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Save Vehicle</button>
                </div>
            </form>
        </div>
    </div>
</div>
