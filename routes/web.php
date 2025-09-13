<?php

use App\Livewire\Dashboard;
use App\Livewire\Systems\Setings;
use App\Livewire\Users;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
// use Illuminatpe\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();
        // Check if user email is verified
        if (!$user->verified()) {
            return redirect()->route('verification.notice')
                ->with('info', 'Please verify your email address to continue.');
        }

        // Check if user has vehicle owner setup using the same method as middleware
        if ($user->isClientUser() && !$user->isVehicleOwner()) {
            return redirect()->route('app.client.onbaord.index');
        } else if ($user->isClientUser() && !$user->isVehicleOwner() && !$user->vehicleOwner->isAtive()) {
            return redirect()->route('app.client.onbaord.account-pending-approval');
        }
        // All checks passed, redirect to dashboard
        return redirect()->route('dashboard');
    } else {
        return redirect()->route('login');
    }
});

Route::get('dashboard', Dashboard::class)
    ->middleware([
        'auth',
        'verified',
        'verify_user_account_setup',
        'validate_active_vehicle_owner'
    ])->name('dashboard');
Route::view('profile', 'profile')->middleware(['auth'])->name('profile');
Route::group(
    [
        'middleware' => ['auth', 'verified', 'check_permissions:users_create,users_view,users_edit,users_delete'],
        'prefix' => 'users'
    ],
    function () {
        Route::get('/register', Users\CeateUser::class)->name('users.create');
        Route::get('/', \App\Livewire\Users\UsersTable::class)->name('users');
        Route::get('/', [\App\Http\Controllers\Administration\UsersController::class, 'index'])->name('users');
        // index
        Route::get('/{id}', \App\Livewire\Users\ViewUser::class)->name('users.view');
        Route::get('/{id}/edit', \App\Livewire\Users\EditUser::class)->name('users.edit');
    }
);

// require __DIR__ . '/clients.php';
require __DIR__ . '/auth.php';
