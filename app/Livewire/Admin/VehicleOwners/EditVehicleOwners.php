<?php

namespace App\Livewire\Admin\VehicleOwners;

use Livewire\Component;
use App\Models\VehicleOwner;
use App\Models\VehicleOwnerType;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class EditVehicleOwners extends Component
{
    public $name;
    public $contact_number;
    public $email;
    public $address;
    public $vehicle_owner_type_id;
    public $vehicleOwnerId;
    public $vehicleOwner;
    public $vehicleOwnerTypes;

    protected $rules = [
        'name' => 'required|string|max:255',
        'contact_number' => 'required|string|max:20',
        'email' => 'required|email|max:255',
        'address' => 'required|string',
        'vehicle_owner_type_id' => 'required|exists:vehicle_owner_types,id',
    ];

    protected $messages = [
        'name.required' => 'Owner name is required.',
        'contact_number.required' => 'Contact number is required.',
        'email.required' => 'Email address is required.',
        'email.email' => 'Please enter a valid email address.',
        'address.required' => 'Address is required.',
        'vehicle_owner_type_id.required' => 'Please select an owner type.',
        'vehicle_owner_type_id.exists' => 'The selected owner type is invalid.',
    ];

    public function mount(string $id)
    {
        $this->vehicleOwner = VehicleOwner::where('uuid', $id)->firstOrFail();
        $this->loadVehicleOwnerTypes();
        $this->initializeFormFields();
    }

    public function loadVehicleOwnerTypes()
    {
        $this->vehicleOwnerTypes = VehicleOwnerType::all();
    }

    public function initializeFormFields()
    {
        // Set form values from the vehicle owner
        $this->name = $this->vehicleOwner->name;
        $this->contact_number = $this->vehicleOwner->contact_number;
        $this->email = $this->vehicleOwner->email;
        $this->address = $this->vehicleOwner->address;
        $this->vehicle_owner_type_id = $this->vehicleOwner->vehicle_owner_type_id;
    }

    public function updateVehicleOwner()
    {
        DB::beginTransaction();

        try {
            $validatedData = $this->validate();

            $this->vehicleOwner->update([
                'name' => $this->name,
                'contact_number' => $this->contact_number,
                'email' => $this->email,
                'address' => $this->address,
                'vehicle_owner_type_id' => $this->vehicle_owner_type_id,
            ]);

            DB::commit();

            session()->flash('message', 'Vehicle owner details updated successfully!');

            return redirect()->route('admin.vehicle-owners.view', $this->vehicleOwner->uuid);
        } catch (ValidationException $e) {
            DB::rollBack();
            // Laravel automatically handles validation errors
            throw $e;
        } catch (Exception $e) {
            DB::rollBack();
            // Flash error message
            session()->flash('error', 'Failed to update vehicle owner: ' . $e->getMessage());
        }
    }

    public function cancelEdit()
    {
        return redirect()->route('admin.vehicle-owners.view', $this->vehicleOwner->uuid);
    }

    public function render()
    {
        return view('livewire.admin.vehicle-owners.edit-vehicle-owners');
    }
}
