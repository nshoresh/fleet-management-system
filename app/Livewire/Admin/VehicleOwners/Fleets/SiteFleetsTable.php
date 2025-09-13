<?php

namespace App\Livewire\Admin\VehicleOwners\Fleets;

use App\Models\Vehicle;
use App\Models\VehicleClassification;
use App\Models\VehicleOwner;
use Livewire\Component;
use Livewire\WithPagination;

class SiteFleetsTable extends Component
{
    use WithPagination;

    public VehicleOwner $vehicleOwner;
    public string $vehicleOwnerId;
    protected $paginationTheme = 'bootstrap'; // Add if using Bootstrap pagination

    public function mount(string $id): void
    {
        $this->vehicleOwnerId = $id;

        $this->vehicleOwner = VehicleOwner::with('vehicle_owner_type')
            ->where('id', $id)
            ->orWhere('uuid', $id)
            ->firstOrFail();
    }

    public function viewDocuments(string $vehicleId)
    {
        return redirect()->route('client.vehicle-documents.document', [
            'vehicleOwnerId' => $this->vehicleOwnerId,
            'vehicleId' => $vehicleId,
        ]);
    }

    public function openModal(): void
    {
        $this->dispatch('open-create-vehicle-modal');
    }

    public function render()
    {
        return view('livewire.admin.vehicle-owners.fleets.site-fleets-table', [
            'vehicles' => Vehicle::where('vehicle_owner_id', $this->vehicleOwner->id)
                ->with(['classification']) // Eager load if needed
                ->paginate(10),
            'vehicleClassifications' => VehicleClassification::all(), // Uncommented if needed
        ]);
    }
}
