<?php

namespace App\Livewire\Admin\VehicleOwners\Users;

use Livewire\Component;
use App\Models\VehicleOwner;
use App\Models\User;
class VehicleOwnerUsers extends Component
{
    public $vehicleOwnerId;
    public $vehicleOwner;
    public $confirmDeletion = false;
    public $userId;
    public $showEditModal = false;

    public int $fleets_count;
    public $users;
    public $isOpen = false;

    protected $listeners = [
        'vehicleOwnerUpdated' => 'loadVehicleOwner',
        'userCreated' => 'loadUsers',
        'userUpdated' => 'loadUsers',
        'userDeleted' => 'loadUsers'
    ];

    public function mount($id)
    {
        $this->vehicleOwnerId = $id;
        $this->loadVehicleOwner();
        $this->loadUsers();
        $this->fleets_count = $this->vehicleOwner->fleets->count();
    }

    public function loadVehicleOwner()
    {
        $this->vehicleOwner = VehicleOwner::with('vehicle_owner_type')
            ->where('uuid', $this->vehicleOwnerId)->firstOrFail();
    }

    public function loadUsers()
    {
        if ($this->vehicleOwner) {
            $this->users = $this->vehicleOwner->users()->get();
        }
    }

    public function refreshData()
    {
        $this->loadVehicleOwner();
        $this->loadUsers();
        $this->fleets_count = $this->vehicleOwner->fleets->count();
    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    public function confirmDelete($userId)
    {
        $this->userId = $userId;
        $this->confirmDeletion = true;
    }

    public function cancelDelete()
    {
        $this->confirmDeletion = false;
        $this->userId = null;
    }

    public function delete()
    {
        $user = User::find($this->userId);
        if ($user) {
            $user->delete();
            $this->refreshData();
            session()->flash('success', 'User deleted successfully.');
        }
        $this->confirmDeletion = false;
        $this->userId = null;
    }

    public function openEditModal($userId)
    {
        $this->userId = $userId;
        $this->showEditModal = true;
    }

    public function closeEditModal()
    {
        $this->showEditModal = false;
        $this->userId = null;
    }

    public function render()
    {
        return view('livewire.admin.vehicle-owners.users.vehicle-owner-users');
    }
}
