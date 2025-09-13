<?php

namespace App\Livewire\Admin\VehicleOwners;

use Livewire\Component;
use App\Models\Vehicle;
use App\Models\VehicleOwner;
use App\Models\VehicleMake;
use App\Models\VehicleMakeModel;
use App\Models\VehicleType;
use Livewire\Attributes\Rule;
use Illuminate\Support\Facades\DB;

class CreateNewVehicleFromOwner extends Component
{
    public $owner_id;
    public VehicleOwner $owner;

    #[Rule('required')]
    public $vehicle_make_id;

    #[Rule('required')]
    public $vehicle_model_id;

    #[Rule('required')]
    public $vehicle_type_id;

    #[Rule('required|string|max:255')]
    public $year;

    #[Rule('required|string|max:50')]
    public $color;

    #[Rule('required|string|max:255|unique:vehicles,vin')]
    public $vin;

    #[Rule('required|string|max:20|unique:vehicles,license_plate')]
    public $license_plate;

    #[Rule('nullable|string|max:50')]
    public $engine_type;

    #[Rule('nullable|integer|min:0')]
    public $mileage;

    #[Rule('nullable|date')]
    public $registration_date;

    #[Rule('required|in:active,inactive,sold')]
    public $status = 'active';

    public $vehicleMakes = [];
    public $vehicleModels = [];
    public $vehicleTypes = [];
    public $success = false;

    public function mount($ownerId)
    {
        $this->owner_id = $ownerId;
        $this->owner = VehicleOwner::findOrFail($ownerId);
        $this->registration_date = now()->format('Y-m-d');

        // Load related data for dropdowns
        $this->loadVehicleMakes();
        $this->loadVehicleTypes();
    }

    public function loadVehicleMakes()
    {
        $this->vehicleMakes = VehicleMake::orderBy('name')->get();
    }

    public function loadVehicleTypes()
    {
        $this->vehicleTypes = VehicleType::orderBy('name')->get();
    }

    public function updatedVehicleMakeId($value)
    {
        $this->vehicleModels = VehicleMakeModel::where('vehicle_make_id', $value)
            ->orderBy('name')
            ->get();

        $this->vehicle_model_id = null;
    }

    public function save()
    {
        $this->validate();

        try {
            DB::beginTransaction();

            $vehicle = new Vehicle([
                'vehicle_make_id' => $this->vehicle_make_id,
                'vehicle_model_id' => $this->vehicle_model_id,
                'vehicle_type_id' => $this->vehicle_type_id,
                'vehicle_owner_id' => $this->owner_id,
                'make' => VehicleMake::find($this->vehicle_make_id)?->name ?? '',
                'model' => VehicleMakeModel::find($this->vehicle_model_id)?->name ?? '',
                'year' => $this->year,
                'color' => $this->color,
                'vin' => $this->vin,
                'license_plate' => $this->license_plate,
                'engine_type' => $this->engine_type,
                'mileage' => $this->mileage,
                'registration_date' => $this->registration_date,
                'status' => $this->status,
                'uuid' => Vehicle::generateUniqueUuid(),
            ]);

            $vehicle->save();

            DB::commit();

            $this->resetFormFields();
            $this->success = true;
            $this->dispatch('vehicle-created', vehicleId: $vehicle->id);
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Failed to create vehicle: ' . $e->getMessage());
        }
    }

    public function resetFormFields()
    {
        $this->reset([
            'vehicle_make_id',
            'vehicle_model_id',
            'vehicle_type_id',
            'year',
            'color',
            'vin',
            'license_plate',
            'engine_type',
            'mileage',
            'registration_date',
            'status'
        ]);
    }

    public function resetForm()
    {
        $this->resetFormFields();
        $this->resetValidation();
        $this->success = false;
        $this->registration_date = now()->format('Y-m-d');
    }
    public function render()
    {
        return view('livewire.admin.vehicle-owners.create-new-vehicle-from-owner');
    }
}
