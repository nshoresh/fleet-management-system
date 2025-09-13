<?php

namespace App\Livewire\Admin\VehicleClassification;

use App\Models\VehicleClassification;
use Livewire\Component;
use Illuminate\Support\Facades\Log;
use Livewire\WithPagination;

class VehicleClassificationTable extends Component
{
    use WithPagination;
    protected $paginationTheme = 'tailwind';

    public $vehicleClassificationId;
    public $editingClassificationId = null;
    public $showModal = false;
    public $showEditModal = false;
    public $confirmingDeletion = false;
    public $search = '';
    public $classificationFilter = '';
    public $perPage = 10;

    protected $listeners = ['refresh' => '$refresh'];

    protected $queryString = ['search' => ['except' => ''], 
                            'classificationFilter' => ['except' => ''],
                            'perPage' => ['except' => 1],
                        ];

    private function getVehicleClassifications()
    {
        return VehicleClassification::orderBy('is_active', 'desc')->get();
    }

        public function updatingSearch()
    {
        $this->resetPage();
    }
    public function updatingClassificationFilter()
    {
        $this->resetPage();
    }
    public function openAddModal()
    {
        $this->showModal = true;
    }

    public function openEditModal($classificationId)
    {
        $this->editingClassificationId = $classificationId;
        $this->showEditModal = true;
    }

    public function closeAddModal()
    {
        $this->showModal = false;
    }

    public function closeEditModal()
    {
        $this->showEditModal = false;
        $this->editingClassificationId = null;
    }

    public function confirmDelete($classificationId)
    {
        $this->vehicleClassificationId = $classificationId;
        $this->confirmingDeletion = true;
    }

    public function cancelDelete()
    {
        $this->confirmingDeletion = false;
        $this->vehicleClassificationId = null;
    }

    public function delete()
    {
        $classification = VehicleClassification::find($this->vehicleClassificationId);

        if ($classification) {
            $classification->delete();
            session()->flash('success', 'Vehicle Classification deleted successfully.');
        }

        $this->confirmingDeletion = false;
        $this->vehicleClassificationId = null;
    }

    public function render()
    {
        $vehicleClassifications = VehicleClassification::where('classification_name', 'like', '%' . $this->search . '%')
            ->where('classification_name', 'like', '%' . $this->classificationFilter . '%')
            ->orderBy('is_active', 'desc')
            ->paginate($this->perPage);
        $vehicleClassifications = $this->getVehicleClassifications()->sortByDesc('is_active');

        return view('livewire.admin.vehicle-classification.vehicle-classification-table', [
            'vehicleClassifications' => $vehicleClassifications,
        ]);
    }
}
