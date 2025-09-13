<?php

namespace App\Livewire\Client\Vehicles;

use App\Models\Vehicle;
use App\Models\VehicleClassification;
use App\Models\VehicleMake;
use App\Models\VehicleMakeModel;
use App\Models\VehicleOwner;
use App\Models\VehicleType;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CreateVehicle extends Component
{
    use WithFileUploads;

    // Model Properties
    public $year;
    public $vin;
    public $color;
    public $license_plate;
    public $engine_type;
    public $mileage;
    public $registration_date;
    public $status = 'active';
    public $vehicle_make_id;
    public $vehicle_model_id;
    public $vehicle_owner_id;
    public $vehicle_type_id;
    public $vehicle_classification_id;
    public $transmission_type;
    public $fuel_type;
    public $seating_capacity;
    public $vehicle_condition;
    public $additional_features;
    public $insurance_status;
    public $last_service_date;
    public $engine_number;
    public $chassis_number;

    //Conditional Logic fields
    public $showVehicleFields = false;
    public $showTrailerFields = false;

    // Heavy vehicle specific fields
    public $gross_vehicle_weight;
    public $vehicle_tare_weight;
    public $gross_trailer_weight;
    public $trailer_tare_weight;
    public $payload_capacity;  // Calculated -> Vehcile Gross Weight - Vehicle Tare Weight
    public $tire_capacity;
    public $axle_configuration;
    public $number_of_axles;
    public $engine_power;
    public $torque;
    public $uuid;

    // Component state properties
    public $makes = [];
    public $models = [];
    public $owners = [];
    public $vehicle_classifications = [];
    public $types = [];
    public $showHeavyVehicleFields = false;
    public $generateVin = true;
    public $successMessage = '';

    // Dropdown options
    public $transmissionOptions = [
        'Automatic',
        'Manual',
        'CVT',
        'Semi-Automatic',
        'Dual-Clutch'
    ];
    public $fuelOptions = [
        'Gasoline',
        'Diesel',
        'Electric',
        'Hybrid',
        'Plug-in Hybrid',
        'CNG',
        'LPG'
    ];
    public $conditionOptions = [
        'New',
        'Used',
        'Certified Pre-Owned',
        'Refurbished'
    ];
    public $insuranceOptions = [
        'Insured',
        'Not Insured',
        'Pending'
    ];
    public $axleOptions = [
        'Single',
        'Tandem',
        'Triple',
        'Quad'
    ];
    public $statusOptions = [
        'active',
        'inactive',
        'sold'
    ];

    protected $listeners = ['refreshFields' => '$refresh'];

    public $years = []; // Array to hold year options

    protected $rules = [
        'year' => 'required|string|max:4',
        'vin' => 'required|string|unique:vehicles,vin|max:17',
        'color' => 'nullable|string|max:50',
        'license_plate' => 'required|string|unique:vehicles,license_plate|max:20',
        'engine_type' => 'nullable|string|max:50',
        'mileage' => 'nullable|integer|min:0',
        'registration_date' => 'nullable|date',
        'status' => 'required|in:active,inactive,sold',
        'vehicle_make_id' => 'required|exists:vehicle_makes,id',
        'vehicle_model_id' => 'required|exists:vehicle_make_models,id',
        'vehicle_type_id' => 'required|exists:vehicle_types,id',
        'vehicle_classification_id' => 'nullable|exists:vehicle_classifications,id',
        'transmission_type' => 'nullable|string|max:50',
        'fuel_type' => 'nullable|string|max:50',
        'seating_capacity' => 'nullable|integer|min:1',
        'vehicle_condition' => 'nullable|string|max:50',
        'additional_features' => 'nullable|string',
        'insurance_status' => 'nullable|string|max:50',
        'last_service_date' => 'nullable|date',
        'engine_number' => 'nullable|string|max:50',
        'chassis_number' => 'nullable|string|max:50',
        // Heavy vehicle specific validations
        'gross_vehicle_weight' => 'nullable|numeric|min:0',
        'vehicle_tare_weight' => 'nullable|numeric|min:0',
        'gross_trailer_weight' => 'nullable|numeric|min:0',
        'trailer_tare_weight' => 'nullable|numeric|min:0',
        //'payload_capacity' => 'required|numeric|min:0', Calculated Gross Vehicle Weight - Vehicle Tare Weight
        'tire_capacity' => 'nullable|numeric|min:0',
        'axle_configuration' => 'nullable|string|max:50',
        'number_of_axles' => 'nullable|integer|min:1',
        'engine_power' => 'nullable|numeric|min:0',
        'torque' => 'nullable|numeric|min:0',

    ];
    protected function rules()
    {
        return [
        'vehicle_type_id' => 'required',
        'gross_vehicle_weight' => $this->showVehicleFields ? 'required|numeric' : 'nullable',
        'vehicle_tare_weight' => $this->showVehicleFields ? 'required|numeric' : 'nullable',
        'gross_trailer_weight' => $this->showTrailerFields ? 'required|numeric' : 'nullable',
        'trailer_tare_weight' => $this->showTrailerFields ? 'required|numeric' : 'nullable',
    ];
    }

    public function mount()
    {

        //Generate years from 1900 to current year + 1
        $currentYear = date('Y');
        $this->years = range(1900, $currentYear);
        
        // Reverse the array to show newest years first
        $this->years = array_reverse($this->years);


        $this->makes = VehicleMake::orderBy('name')->get();
        $this->owners = VehicleOwner::orderBy('name')->get();
        $this->types = VehicleType::orderBy('name')->get();
        $this->vehicle_classifications = VehicleClassification::orderBy('classification_name')->get();
        $this->registration_date = now()->format('Y-m-d');
        $this->year = now()->format('Y');
        $this->vehicle_owner_id = Auth::user()->vehicleOwner->id;
    }

    public function updatedVehicleMakeId($value)
    {
        $this->models = VehicleMakeModel::where('vehicle_make_id', $value)
            ->orderBy('name')->get();
        //$this->vehicle_model_id = null;
    }

    public function updatedVehicleTypeId($value)
    {
        // Check if the selected vehicle type is a heavy vehicle type
        $vehicleType = VehicleType::find($value);
        if ($vehicleType) {
            // Assuming VehicleType has a 'category' field that can be 'heavy', 'light', etc.
            // Or you could have a specific list of heavy vehicle type IDs
            $this->showHeavyVehicleFields = in_array($vehicleType->name, [
                'Truck',
                'Semi',
                'Heavy Duty',
                'Commercial'
            ]);
        }
        
        // Reset all fields first
        $this->showVehicleFields = false;
        $this->showTrailerFields = false;
        
        $this->reset(['gross_vehicle_weight', 'vehicle_tare_weight', 
                'gross_trailer_weight', 'trailer_tare_weight']);

        // Determine what to show based on selection
        if (empty($value)) {
            // Show all fields when nothing is selected
            $this->showVehicleFields = true;
            $this->showTrailerFields = true;
        } elseif ($value == 31) { // <-- Now checking for Trailer ID (31) instead of name
            // Show only trailer fields
            $this->showTrailerFields = true;
        } else {
            // Show only vehicle fields for all other selections
            $this->showVehicleFields = true;
        }
    }

    public function updatedGenerateVin($value)
    {
        if ($value) {
            $this->vin = Vehicle::generateUniqueVin();
        } else {
            $this->vin = '';
        }
    }
    public function updatedInsuranceStatus($value)
    {
        if ($value == 'Insured') {
            $this->insurance_status = 'Insured';
        } else {
            $this->insurance_status = 'Not Insured';
        }
    }



    public function saveVehicle()
    {
        // If auto-generating VIN is enabled, generate a new VIN
        if ($this->generateVin) {
            $this->vin = Vehicle::generateUniqueVin();
        }

        $this->uuid = Vehicle::generateUniqueUuid();
        $this->validate();

        try {
            DB::beginTransaction();

            $vehicle = Vehicle::create([
                'uuid' => $this->uuid,
                'year' => $this->year,
                'vin' => $this->vin,
                'color' => $this->color,
                'license_plate' => $this->license_plate,
                'engine_type' => $this->engine_type,
                'mileage' => $this->mileage,
                'registration_date' => $this->registration_date,
                'status' => $this->status,
                'vehicle_make_id' => $this->vehicle_make_id,
                'vehicle_model_id' => $this->vehicle_model_id,
                'vehicle_owner_id' => $this->vehicle_owner_id,
                'vehicle_type_id' => $this->vehicle_type_id,
                'vehicle_classification_id' => $this->vehicle_classification_id,
                'transmission_type' => $this->transmission_type,
                'fuel_type' => $this->fuel_type,
                'seating_capacity' => $this->seating_capacity,
                'vehicle_condition' => $this->vehicle_condition,
                'additional_features' => $this->additional_features,
                'insurance_status' => $this->insurance_status,
                'last_service_date' => $this->last_service_date,
                'engine_number' => $this->engine_number,
                'chassis_number' => $this->chassis_number,
                'gross_vehicle_weight' => $this->gross_vehicle_weight,
                'vehicle_tare_weight' => $this->vehicle_tare_weight,
                'gross_trailer_weight' => $this->gross_trailer_weight,
                'trailer_tare_weight' => $this->trailer_tare_weight,
                //'payload_capacity' => $this->payload_capacity,
                'tire_capacity' => $this->tire_capacity,
                'axle_configuration' => $this->axle_configuration,
                'number_of_axles' => $this->number_of_axles,
                'engine_power' => $this->engine_power,
                'torque' => $this->torque,
            ]);

            DB::commit();

            $this->successMessage = 'Vehicle created successfully!';
            $this->reset([
                'year',
                'vin',
                'color',
                'license_plate',
                'engine_type',
                'mileage',
                'transmission_type',
                'fuel_type',
                'seating_capacity',
                'vehicle_condition',
                'additional_features',
                'insurance_status',
                'last_service_date',
                'gross_vehicle_weight',
                'gross_trailer_weight',
                'payload_capacity',
                'tire_capacity',
                'axle_configuration',
                'number_of_axles',
                'engine_power',
                'torque',
                'engine_number',
                'chassis_number'
            ]);

            $this->year = now()->format('Y');
            $this->registration_date = now()->format('Y-m-d');
            $this->status = 'active';
            $this->generateVin = true;
            $this->vin = Vehicle::generateUniqueVin();
            $this->dispatch('vehicleCreated');
            session()->flash('success', 'Vehicle created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash(
                'error',
                'Error creating vehicle: ' . $e->getMessage()
            );
        }
    }

    public function render()
    {
        return view('livewire.client.vehicles.create-vehicle');
            //->layout('layouts.app');
    }
}
