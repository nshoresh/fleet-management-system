<?php

namespace App\Livewire\Vehicles;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Vehicle;
use App\Models\VehicleMake;
use App\Models\VehicleMakeModel;
use App\Models\VehicleType;
use App\Models\VehicleColor;
use App\Models\FuelType;
use App\Models\TransmissionType;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Create extends Component
{
    use WithFileUploads;

    // Basic info
    public $vin;
    public $registration_number;
    public $year;
    public $vehicle_make_id;
    public $vehicle_model_id;
    public $vehicle_type_id;
    public $vehicle_color_id;
    public $mileage;
    public $engine_number;
    public $chassis_number;

    // Technical specifications
    public $engine_capacity;
    public $fuel_type_id;
    public $transmission_type_id;
    public $power;
    public $torque;
    public $seats;
    public $doors;

    // Financial info
    public $purchase_date;
    public $purchase_price;
    public $market_value;

    // Additional info
    public $description;
    public $status = 'available';
    public $photos = [];

    // Dropdown selections
    public $makes = [];
    public $models = [];
    public $vehicleTypes = [];
    public $colors = [];
    public $fuelTypes = [];
    public $transmissionTypes = [];

    // Validation rules
    protected function rules()
    {
        return [
            'vin' => 'required|string|max:17|unique:vehicles,vin',
            'registration_number' => 'required|string|max:20|unique:vehicles,registration_number',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'vehicle_make_id' => 'required|exists:vehicle_makes,id',
            'vehicle_model_id' => 'required|exists:vehicle_models,id',
            'vehicle_type_id' => 'required|exists:vehicle_types,id',
            'vehicle_color_id' => 'required|exists:vehicle_colors,id',
            'mileage' => 'required|numeric|min:0',
            'engine_number' => 'nullable|string|max:50',
            'chassis_number' => 'nullable|string|max:50',

            'engine_capacity' => 'nullable|numeric|min:0',
            'fuel_type_id' => 'required|exists:fuel_types,id',
            'transmission_type_id' => 'required|exists:transmission_types,id',
            'power' => 'nullable|numeric|min:0',
            'torque' => 'nullable|numeric|min:0',
            'seats' => 'nullable|integer|min:1|max:100',
            'doors' => 'nullable|integer|min:0|max:10',

            'purchase_date' => 'nullable|date',
            'purchase_price' => 'nullable|numeric|min:0',
            'market_value' => 'nullable|numeric|min:0',

            'description' => 'nullable|string',
            'status' => 'required|in:available,maintenance,rented,sold,reserved',
            'photos.*' => 'nullable|image|max:5120', // 5MB max per image
        ];
    }

    // Custom validation messages
    protected $messages = [
        'vin.required' => 'The VIN is required.',
        'vin.unique' => 'This VIN is already registered in the system.',
        'registration_number.required' => 'The registration number is required.',
        'registration_number.unique' => 'This registration number is already registered in the system.',
        'photos.*.max' => 'Each photo must not exceed 5MB in size.',
    ];

    public function mount()
    {
        $this->loadDropdownData();
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);

        if ($propertyName === 'vehicle_make_id') {
            $this->vehicle_model_id = null;
            $this->loadModels();
        }
    }

    public function loadDropdownData()
    {
        $this->makes = VehicleMake::orderBy('name')->get();
        $this->vehicleTypes = VehicleType::orderBy('name')->get();
        $this->colors = VehicleColor::orderBy('name')->get();
        $this->fuelTypes = FuelType::orderBy('name')->get();
        $this->transmissionTypes = TransmissionType::orderBy('name')->get();

        if ($this->vehicle_make_id) {
            $this->loadModels();
        } else {
            $this->models = [];
        }
    }

    public function loadModels()
    {
        if ($this->vehicle_make_id) {
            $this->models = VehicleMakeModel::where('vehicle_make_id', $this->vehicle_make_id)
                ->orderBy('name')
                ->get();
        } else {
            $this->models = [];
        }
    }

    public function saveVehicle()
    {
        $validatedData = $this->validate();

        // Remove photos from validated data to handle separately
        $photos = $validatedData['photos'] ?? [];
        unset($validatedData['photos']);

        DB::beginTransaction();

        try {
            // Create vehicle
            $vehicle = Vehicle::create($validatedData);

            // Handle photo uploads
            $photoUploads = [];
            foreach ($photos as $index => $photo) {
                $filename = Str::random(20) . '.' . $photo->getClientOriginalExtension();
                $path = $photo->storeAs('vehicle-photos/' . $vehicle->id, $filename, 'public');

                $photoUploads[] = [
                    'vehicle_id' => $vehicle->id,
                    'path' => $path,
                    'is_primary' => $index === 0, // First photo is primary
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            if (count($photoUploads) > 0) {
                DB::table('vehicle_photos')->insert($photoUploads);
            }

            DB::commit();

            session()->flash('success', 'Vehicle created successfully!');
            return redirect()->route('vehicles.index');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Failed to create vehicle: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.vehicles.create')->layout('layouts.app');
    }
}
