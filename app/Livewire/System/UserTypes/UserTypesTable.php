<?php

namespace App\Livewire\System\UserTypes;

use Livewire\Component;
use App\Models\UserType;
use Livewire\WithPagination;

class UserTypesTable extends Component
{
    public function render()
    {
        return view('livewire.system.user-types.user-types-table', [
            'userTypes' => UserType::paginate(10)
        ]);
    }
}
