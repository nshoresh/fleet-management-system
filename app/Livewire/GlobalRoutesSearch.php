<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Route; // Assuming Route model exists
use App\Models\RoutesIndex; // Assuming ModelIndex model exists

class GlobalRoutesSearch extends Component
{
    public $search = ''; // Property to bind search input
    public $minSearchLength = 4; // Minimum search length required

    public function render()
    {
        // Get matching records only if search is at least 3 characters
        $routes = collect(); // Empty collection by default

        if (strlen(strtolower($this->search)) >= $this->minSearchLength) {
            $routes = RoutesIndex::where(
                'uri',
                'like',
                '%' . strtolower($this->search) . '%'
            )
                ->orWhere(
                    'name',
                    'like',
                    '%' . strtolower($this->search) . '%'
                )
                ->get();
        }

        return view('livewire.global-routes-search', compact('routes'));
    }
}
