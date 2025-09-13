<?php

namespace App\Livewire\Admin\VehicleOwners;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\VehicleOwner;
use App\Models\VehicleOwnerType;
use Dotenv\Exception\ValidationException;
use Exception;
use Illuminate\Support\Facades\DB;

class VehicleOwnersTable extends Component
{
    use WithPagination;

    public $perPage = 10;
    public $search = '';
    public $ownerTypeFilter = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $showDeleteModal = false;
    public $ownerIdBeingDeleted = null;
    public $showAddModal = false;
    public $newOwner = [
        'name' => '',
        'email' => '',
        'contact_number' => '',
        'address' => '',
        'vehicle_owner_type_id' => '',
    ];

    protected $queryString = [
        'perPage',
        'ownerTypeFilter',
        'sortField',
        'sortDirection',
        'search'
    ];
    public function openAddModal()
    {
        $this->showAddModal = true; // Set the modal visibility to true
    }

    public function closeAddModal()
    {
        $this->showAddModal = false; // Set the modal visibility to true
    }

    public function saveOwner()
    {
        try {

            DB::beginTransaction();
            // Validate the input fields
            $validatedData = $this->validate([
                'newOwner.name' => 'required|string|max:255',
                'newOwner.email' => 'required|email|unique:vehicle_owners,email',
                'newOwner.contact_number' => 'required|string|max:15',
                'newOwner.address' => 'required|string|max:500',
                'newOwner.vehicle_owner_type_id' => 'required|exists:vehicle_owner_types,id',
            ]);

            // Create a new vehicle owner record
            VehicleOwner::create($validatedData['newOwner']);
            DB::commit();

            // Reset the form fields
            $this->reset('newOwner');

            // Close the modal
            $this->closeAddModal();

            // Flash a success message
            session()->flash('message', 'Vehicle owner created successfully.');
        } catch (ValidationException $e) {
            DB::rollBack();
            // Laravel authomatically handle validation errors
            throw $e;
        } catch (Exception $e) {
            DB::rollback();
            // Flash an error message
            session()->flash('error', 'Fail to create vehicle owner: ' . $e->getMessage());
        }
    }

    // Add these methods to your Livewire component class
    public function confirmDelete($ownerId)
    {
        $this->ownerIdBeingDeleted = $ownerId;
        $this->showDeleteModal = true;
    }

    public function cancelDelete()
    {
        $this->ownerIdBeingDeleted = null;
        $this->showDeleteModal = false;
    }

    public function deleteOwner()
    {
        // Perform the actual deletion
        $owner = VehicleOwner::find($this->ownerIdBeingDeleted);

        if ($owner) {
            $owner->delete();
            session()->flash('message', 'Vehicle owner deleted successfully.');
        }

        // Close the modal
        $this->ownerIdBeingDeleted = null;
        $this->showDeleteModal = false;
    }
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingOwnerTypeFilter()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function edit($id)
    {
        return redirect()->route(
            'admin.vehicle-owners.edit',
            $id
        );
    }

    public function delete($id)
    {
        VehicleOwner::destroy($id);
    }

    //protected $layout = 'layouts.app';

    public function render()
    {
        $ownerTypes = VehicleOwnerType::orderBy('name')->get();

        $vehicleOwners = VehicleOwner::query()
            ->when(
                $this->search,
                function ($query) {
                    return $query->where(function ($query) {
                        $query->where(
                            'business_name',
                            'like',
                            '%' . $this->search . '%'
                        )
                            ->orWhere(
                                'business_email',
                                'like',
                                '%' . $this->search . '%'
                            )
                            ->orWhere(
                                'contact_number',
                                'like',
                                '%' . $this->search . '%'
                            );
                    });
                }
            )
            ->when($this->ownerTypeFilter, function ($query) {
                return $query->where(
                    'vehicle_owner_type_id',
                    $this->ownerTypeFilter
                );
            })
            ->orderBy(
                $this->sortField,
                $this->sortDirection
            )
            ->paginate($this->perPage);

        return view('livewire.admin.vehicle-owners.vehicle-owners-table', [
            'vehicleOwners' => $vehicleOwners,
            'ownerTypes' => $ownerTypes
        ])/*->layout('layouts.app')*/;
    }
}
