<?php

namespace App\Livewire\Examples;

use Livewire\Component;
use App\Models\User;

class FlexibleTableDataExample extends Component
{
    public function deleteUser($userId)
    {
        // Logic to delete a user
        User::find($userId)->delete();
        session()->flash('message', 'User deleted successfully.');
    }

    public function editUser($userId)
    {
        // Logic to redirect to edit user page or show edit modal
        return redirect()->route('users.edit', $userId);
    }
    public function render()
    {
        $users = User::all()->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'created_at' => $user->created_at,
                'status' => $user->status,
                'verified' => $user->email_verified_at != null,

            ];
        })->toArray();

        // Define the columns for the table
        $columns = [
            [
                'field' => 'name',
                'label' => 'Name',
                'sortable' => true,
                'filterable' => true,
            ],
            [
                'field' => 'email',
                'label' => 'Email',
                'sortable' => true,
                'filterable' => true,
            ],


            [
                'field' => 'created_at',
                'label' => 'Joined',
                'sortable' => true,
                'type' => 'date',
            ],

            [
                'field' => 'verified',
                'label' => 'Verified',
                'sortable' => true,
                'filterable' => true,
                'type' => 'boolean',
            ],

        ];
        return view('livewire.examples.flexible-table-data-example', [
            'tableData' => $users,
            'tableColumns' => $columns,
        ]);
    }
}
