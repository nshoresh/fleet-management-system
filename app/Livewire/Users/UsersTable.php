<?php

namespace App\Livewire\Users;

use App\Models\AccountStatus;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;

class UsersTable extends Component
{
    use WithPagination; // This trait provides pagination functionality

    public $search = '';
    public $role_filter = '';
    public $status_filter = '';
    public $roles;
    public $account_statuses;
    public $selectedUserId = null;
    public $userId;
    public $accountStatusId;
    public $statusNote = '';

    public $confirmDeletion = false;
    public function mount()
    {
        $this->roles = Role::all();
        $this->account_statuses = AccountStatus::all();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingRoleFilter()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    // Status update methods
    public function updateUserStatus()
    {

        $this->validate([
            'accountStatusId' => 'required|exists:account_statuses,id',
        ]);

        try {
            $user = User::findOrFail($this->selectedUserId);

            // Update the user's status
            $user->account_status_id = $this->accountStatusId;
            $user->save();

            // Optional: Log the status change with note


            // Reset the form
            $this->reset(['selectedUserId', 'accountStatusId', 'statusNote']);

            // Show success notification
            session()->flash('message', 'User status updated successfully.');

            // Close the modal using JavaScript
            $this->dispatch('close-modal', 'update-status-modal');
        } catch (\Exception $e) {
            // Log error
            Log::error('Error updating user status: ' . $e->getMessage());

            // Show error notification
            session()->flash('error', 'Failed to update user status.');
        }
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
            session()->flash('success', 'User deleted successfully.');
        }
        $this->confirmDeletion = false;
        $this->userId = null;

        //return redirect()->route('users');
    }
    public function render()
    {
        try {
            $usersQuery = User::query();

            // Filter by search term (name or email)
            if ($this->search) {
                $usersQuery->where(function ($query) {
                    $query->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            }

            // Filter by role
            if ($this->role_filter) {
                $usersQuery->where('role_id', $this->role_filter);
            }

            // Filter by account status
            if ($this->status_filter) {
                $usersQuery->where('account_status_id', $this->status_filter);
            }

            $filteredUsers = $usersQuery->with(['role', 'account_status'])->paginate(10);
            return view(
                'livewire.users.users-table',
                compact('filteredUsers')
            )
                ->layout('layouts.app');
        } catch (\Throwable $e) {
            # code...
            Log::info($e->getMessage());
        }
    }
}
