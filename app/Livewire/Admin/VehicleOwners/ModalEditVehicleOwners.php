<?php

namespace App\Livewire\Admin\VehicleOwners;

use Livewire\Component;
use App\Models\VehicleOwner;
use App\Models\VehicleOwnerType;
use Dotenv\Exception\ValidationException;
use Illuminate\Support\Facades\DB;
use Exception;

class ModalEditVehicleOwners extends Component
{
    public $name;
    public $contact_number;
    public $email;
    public $address;
    public $vehicle_owner_type_id;
    public $vehicleOwnerId;
    public $vehicleOwner;
    public $vehicleOwnerTypes;
    public $isOpen = false;


    protected $listeners = ['openModal', 'closeModal'];

    protected $rules = [
        'name' => 'required|string|max:255',
        'contact_number' => 'required|string|max:20',
        'email' => 'required|email|max:255',
        'address' => 'required|string',
        'vehicle_owner_type_id' => 'required|exists:vehicle_owner_types,id',
    ];

    public function mount()
    {
        $this->loadVehicleOwnerTypes();
    }

    public function loadVehicleOwnerTypes()
    {
        $this->vehicleOwnerTypes = VehicleOwnerType::all();
    }

    public function openModal($id)
    {
        $this->resetValidation();
        $this->resetExcept(['vehicleOwnerTypes']);

        $this->vehicleOwnerId = $id;
        $this->loadVehicleOwner();
        $this->initializeFormFields();

        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    public function loadVehicleOwner()
    {
        $this->vehicleOwner = VehicleOwner::with('vehicle_owner_type')
            ->findOrFail($this->vehicleOwnerId);
    }

    public function initializeFormFields()
    {
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
            $validateData = $this->validate();
            $this->vehicleOwner->update($validateData);

           //this->vehicleOwner->update([
             // 'name' => $this->name,
            //  'contact_number' => $this->contact_number,
            //  'email' => $this->email,
             // 'address' => $this->address,
             // 'vehicle_owner_type_id' => $this->vehicle_owner_type_id,
           //);
            // Close Modal and commit transaction
            $this->closeModal();
            DB::commit();

            // Notify parent component and show success message
            $this->dispatch('vehicleOwnerUpdated');
            session()->flash('message', 'Vehicle owner details updated successfully!');

        } catch (ValidationException $e){
            DB::rollBack();
            // Laravel automatically handle the validation exception
            throw $e;

        } catch (Exception $e){
            DB::rollBack();
            // Flash error message
            session()->flash('error', 'Fail to update vehicle owner: ' . $e->getMessage());
        }
    }
    public function render()
    {
        return view('livewire.admin.vehicle-owners.modal-edit-vehicle-owners');
    }
}
