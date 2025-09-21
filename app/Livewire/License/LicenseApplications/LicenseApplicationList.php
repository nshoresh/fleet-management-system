<?php

namespace App\Livewire\License\LicenseApplications;

use App\Models\LicenseApplication;
use App\Models\LicenseType;
use App\Models\Vehicle;
use Livewire\Component;
use Livewire\WithPagination;

class LicenseApplicationList extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    // Search and filter properties
    public $search = '';
    public $statusFilter = '';
    public $perPage = 10;

    // Application form fields
    public $applicationId;
    public $applicationNumber;
    public $userId;
    public $vehicleId;
    public $licenseTypeId;
    public $status;

    // Modal states
    public $showDeleteModal = false;
    public $showEditModal = false;
    public $showViewModal = false;

    // Flash messages
    protected $listeners = [
        'refresh' => '$refresh',
    ];

    // Reset pagination when filters change
    public function updatingSearch() { $this->resetPage(); }
    public function updatingStatusFilter() { $this->resetPage(); }
    public function updatingPerPage() { $this->resetPage(); }

    // ------------------------------
    // View application details
    // ------------------------------
    public function viewApplication($id)
    {
        $this->applicationId = $id;
        $this->showViewModal = true;
    }

    // ------------------------------
    // Open edit modal
    // ------------------------------
    public function editApplication($id)
    {
        $this->resetValidation();
        $this->resetApplicationFields();

        $app = LicenseApplication::findOrFail($id);

        $this->applicationId = $app->id;
        $this->applicationNumber = $app->application_number;
        $this->userId = $app->user_id;
        $this->vehicleId = $app->vehicle_id;
        $this->licenseTypeId = $app->license_type_id;
        $this->status = $app->status;

        $this->showEditModal = true;
    }

    // ------------------------------
    // Save edited application
    // ------------------------------
    public function updateApplication()
    {
        $this->validate([
            'applicationNumber' => 'required|string|max:50',
            'userId' => 'required|exists:users,id',
            'vehicleId' => 'nullable|exists:vehicles,id',
            'licenseTypeId' => 'nullable|exists:license_types,id',
            'status' => 'required|string|in:Pending,Approved,Rejected,Completed',
        ]);

        $app = LicenseApplication::findOrFail($this->applicationId);

        $app->update([
            'application_number' => $this->applicationNumber,
            'user_id' => $this->userId,
            'vehicle_id' => $this->vehicleId,
            'license_type_id' => $this->licenseTypeId,
            'status' => $this->status,
        ]);

        $this->showEditModal = false;
        $this->dispatchBrowserEvent('alert', [
            'type' => 'success',
            'message' => 'Application updated successfully!'
        ]);
    }

    // ------------------------------
    // Confirm delete
    // ------------------------------
    public function confirmDelete($id)
    {
        $this->applicationId = $id;
        $this->showDeleteModal = true;
    }

    // ------------------------------
    // Delete application
    // ------------------------------
    public function deleteApplication()
    {
        $app = LicenseApplication::findOrFail($this->applicationId);
        $app->delete();

        $this->showDeleteModal = false;
        $this->dispatchBrowserEvent('alert', [
            'type' => 'success',
            'message' => 'Application deleted successfully!'
        ]);
    }

    // ------------------------------
    // Reset fields
    // ------------------------------
    public function resetApplicationFields()
    {
        $this->applicationId = null;
        $this->applicationNumber = '';
        $this->userId = '';
        $this->vehicleId = '';
        $this->licenseTypeId = '';
        $this->status = 'Pending';
    }

    // ------------------------------
    // Close modals
    // ------------------------------
    public function closeModal()
    {
        $this->showEditModal = false;
        $this->showDeleteModal = false;
        $this->showViewModal = false;
        $this->resetValidation();
        $this->resetApplicationFields();
    }

    // ------------------------------
    // Get application details for view modal
    // ------------------------------
    public function getApplicationDetailsProperty()
    {
        if (!$this->applicationId) {
            return null;
        }

        return LicenseApplication::with(['user', 'vehicle', 'licenseType'])
            ->findOrFail($this->applicationId);
    }

    // ------------------------------
    // Render
    // ------------------------------
    public function render()
    {
        $query = LicenseApplication::with(['user', 'licenseType', 'vehicle']);

        // Search functionality
        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('application_number', 'like', '%' . $this->search . '%')
                  ->orWhere('status', 'like', '%' . $this->search . '%')
                  ->orWhereHas('user', function ($uq) {
                      $uq->where('name', 'like', '%' . $this->search . '%');
                  });
            });
        }

        // Apply filters
        if (!empty($this->statusFilter)) {
            $query->where('status', $this->statusFilter);
        }

        $applications = $query->orderBy('id', 'desc')->paginate($this->perPage);

        $licenseTypes = LicenseType::all();
        $vehicles = Vehicle::all();

        return view('livewire.license.license-applications.license-application-list', [
            'applications' => $applications,
            'licenseTypes' => $licenseTypes,
            'vehicles' => $vehicles,
        ])/*->layout('layouts.app')*/;
    }
}
