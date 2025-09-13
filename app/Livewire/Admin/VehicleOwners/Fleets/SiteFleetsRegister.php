<?php

namespace App\Livewire\Admin\VehicleOwners\Fleets;

use Livewire\Component;
use App\Models\Vehicle;
use App\Models\VehicleMake;
use App\Models\VehicleMakeModel;
use App\Models\VehicleOwner;
use App\Models\VehicleType;
use App\Models\VehicleClassification;
use Illuminate\Support\Facades\Log;

class SiteFleetsRegister extends Component
{
    public $vehicleOwnerId;

    // Form fields
    public $make = '';
    public $model = '';
    public $year = '';
    public $vin = '';
    public $color = '';
    public $plate_number = '';
    public $engine_type = '';
    public $mileage = null;
    public $gross_vehicle_weight = null;
    public $vehicle_tare_weight = null;
    public $gross_trailer_weight = null;
    public $trailer_tare_weight = null;
    public $vehicle_make_id = '';
    public $vehicle_model_id = '';

    public $vehicle_classification_id = '';
    // public $vehicle_owner_id = null;
    public $vehicle_type_id = null;
    public $owner;
    public $vehicle;

    // Add property to store filtered models
    public $availableModels = [];

    // Dynamic validation rules
    protected function rules()
    {
        return [
            // 'make' => 'required|string|max:100',
            // 'model' => 'required|string|max:100',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'vin' => 'nullable|unique:vehicles,vin|size:17',
            'color' => 'nullable|string|max:50',
            'plate_number' => 'required|unique:vehicles,license_plate|string|max:20',
            'engine_type' => 'nullable|string|max:50',
            'mileage' => 'nullable|integer|min:0',
            'gross_vehicle_weight' => 'nullable|numeric|min:0',
            'vehicle_tare_weight' => 'nullable|numeric|min:0',
            'gross_trailer_weight' => 'nullable|numeric|min:0',
            'trailer_tare_weight' => 'nullable|numeric|min:0',
            'vehicle_make_id' => 'required|integer|min:0',
            'vehicle_model_id' => 'required|integer|min:0',
            'vehicle_type_id' => 'required|exists:vehicle_types,id',
            'vehicle_classification_id' => 'required|exists:vehicle_classifications,id',
        ];
    }

    /**
     * Custom validation error messages
     *
     * @return array
     */
    protected function messages()
    {
        return [
            'year.required' => 'The manufacturing year is required.',
            'plate_number.required' => 'The license plate number is required.',
            'plate_number.unique' => 'This license plate number is already in use.',
            'vin.unique' => 'This VIN is already registered.',
            'vin.size' => 'The VIN must be exactly 17 characters long.',
            'vehicle_owner_id.required' => 'Please select a vehicle owner.',
            'vehicle_type_id.required' => 'Please select a vehicle type.',
            'vehicle_make_id' => 'Please select a vehicle Make.',
            'vehicle_model_id' => 'Please select a vehicle Model.',
            'vehicle_classification_id.required' => 'Please select a vehicle classification.',
            'gross_vehicle_weight.numeric' => 'Gross vehicle weight must be a number.',
            'vehicle_tare_weight.numeric' => 'Vehicle tare weight must be a number.',
            'gross_trailer_weight.numeric' => 'Gross trailer weight must be a number.',
            'trailer_tare_weight.numeric' => 'Trailer tare weight must be a number.',
        ];
    }

    /**
     * Create a new vehicle
     */
    public function createVehicle()
    {
        // Validate input
        $validatedData = $this->validate();

        // Generate VIN if not provided
        if (empty($validatedData['vin'])) {
            $validatedData['vin'] = Vehicle::generateUniqueVin();
        }

        try {
            $this->vehicle = Vehicle::create([
                'year' => $validatedData['year'],
                'vin' => $validatedData['vin'],
                'color' => $validatedData['color'],
                'license_plate' => $validatedData['plate_number'],
                'engine_type' => $validatedData['engine_type'],
                'mileage' => $validatedData['mileage'],
                'gross_vehicle_weight' => $validatedData['gross_vehicle_weight'] ?? null,
                'vehicle_tare_weight' => $validatedData['vehicle_tare_weight'] ?? null,
                'gross_trailer_weight' => $validatedData['gross_trailer_weight'] ?? null,
                'trailer_tare_weight' => $validatedData['trailer_tare_weight'] ?? null,
                'vehicle_make_id' => $validatedData['vehicle_make_id'],
                'vehicle_model_id' => $validatedData['vehicle_model_id'],
                'vehicle_owner_id' => $this->vehicleOwnerId,
                'vehicle_type_id' => $validatedData['vehicle_type_id'],
                'vehicle_classification_id' => $validatedData['vehicle_classification_id'],
                'status' => 'active',
            ]);

            // Dispatch success notification
            $this->dispatch('vehicle-created', message: 'Vehicle successfully added!');

            // Reset form
            $this->reset();

            // Optional: redirect or show success message
            session()->flash('success', 'Vehicle added successfully.');
        } catch (\Exception $e) {
            // Log error and show generic error message
            Log::error('Vehicle creation failed: ' . $e->getMessage());
            session()->flash('error', 'Failed to add vehicle. Please try again.');
        }
    }

    public function mount($vehicleOwnerId)
    {
        $this->vehicleOwnerId = $vehicleOwnerId;
        $this->owner = VehicleOwner::find($this->vehicleOwnerId);
    }

    /**
     * Watch for changes to vehicle_make_id and update the available models
     */
    public function updatedVehicleMakeId($value)
    {
        // Reset the selected model
        $this->reset('vehicle_model_id');

        // Only fetch models if a make is selected
        if (!empty($value)) {
            $this->availableModels = VehicleMakeModel::where('vehicle_make_id', $value)->get();
        } else {
            $this->availableModels = [];
        }
    }

    public function updated($propertyName)
    {
        // Real-time validation
        $this->validateOnly($propertyName);
    }

    public function render()
    {
        return view('livewire.admin.vehicle-owners.fleets.site-fleets-register', [
            // 'owners' => VehicleOwner::all(), // Fetch all vehicle owners
            'types' => VehicleType::all(), // Fetch all vehicle types
            'VehicleMakes' => VehicleMake::all(), // Fetch all vehicle makes
            'VehicleMakeModels' => VehicleMakeModel::all(), // Referecing VehicleMakeModel model
            'vehicleClassifications' => VehicleClassification::all(), // Fetch all vehicle classifications
            //'vehicleClassifications' => $this->vehicleClassifications,
            'owner' => $this->owner
        ]);
    }
}
