<?php

namespace App\Livewire\Admin\VehicleRoutes;

use Livewire\Component;
use App\Models\Route;
use App\Models\RouteType;
use Livewire\WithPagination;

class ViewVehicleRoutes extends Component
{
    use WithPagination;

    public $routeId;
    public $route;
    //public $districts;
    public $isModalOpen = false;
    public $route_name;

    //protected $rules = [
       //'route_name' => 'required|string|max:255|unique:districts,name',
    //];

    public function mount($routeId = null)
    {
        if (!$routeId) {
            abort(404, 'Route ID is required.');
        }

        $this->routeId = $routeId;
        //$this->route = Province::with('districts')->find($routeId);

        if (!$this->route) {
            abort(404, 'Route not found.');
        }

        //$this->districts = $this->province->districts;
    }

    public function openModal()
    {
        $this->resetValidation();
        $this->reset(['name']);
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
    }

    public function render()
    {
        return view('livewire.admin.vehicle-routes.view-vehicle-routes', [
            'province' => $this->province,
            //'districts' => $this->districts,
        ])->layout('layouts.app');
    }
}
