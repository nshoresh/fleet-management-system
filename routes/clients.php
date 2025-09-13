<?php

use App\Livewire\Dashboard;
use App\Livewire\Systems\Setings;
use App\Livewire\Users;
use Illuminate\Routing\RouteGroup;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::group(
    [
        'middleware' => []
    ],
    
    function () {
        Route::group(['prefix' => 'onboarding'], function () {
            Route::get('/', [\App\Http\Controllers\Client\Home\OnBoarding::class, 'index'])->name('app.client.onbaord.index');
            Route::get('/account-setup', [\App\Http\Controllers\Client\Home\OnBoarding::class, 'accountSetup'])->name('app.client.onbaord.account-setup');
            Route::get('/account', [\App\Http\Controllers\Client\Home\OnBoarding::class, 'accountPendingApproval'])->name('app.client.onbaord.account-pending-approval');
        });

        Route::group(['prefix' => 'users', 'middleware' => ['verify_user_account_setup', 'vehicle.owner', 'validate_active_vehicle_owner']], function () {
            Route::get('/', [\App\Http\Controllers\Clients\UsersController::class, 'index'])->name('app.users');
            Route::get('/create', \App\Livewire\Client\Users\CreateUser::class)->name('app.users_create');
        });

        Route::group(
            ['prefix' => 'vehicles', 'middleware' => ['verify_user_account_setup', 'vehicle.owner', 'validate_active_vehicle_owner']],
            function () {
                Route::get('/{id}/view', [\App\Http\Controllers\Clients\VehicleController::class, 'show'])->name('app.vehicles_view');
                Route::get('/{id}/edit', \App\Livewire\Client\Vehicles\UpdateVehicle::class)->name('app.vehicles_edit');
                Route::get('/', [\App\Http\Controllers\Clients\VehicleController::class, 'index'])->name('app.vehicles_list');
                Route::get('/create', \App\Livewire\Client\Vehicles\CreateVehicle::class)->name('app.vehicles_create');

            // ✅ Global download routes (all vehicles)
                Route::get('/download-pdf', [\App\Http\Controllers\Clients\VehicleController::class, 'downloadAllPdf'])
                    ->name('app.vehicles_download_pdf');

                Route::get('/download-excel', [\App\Http\Controllers\Clients\VehicleController::class, 'downloadAllExcel'])
                    ->name('app.vehicles_download_excel');

                Route::get('/download-csv', [\App\Http\Controllers\Clients\VehicleController::class, 'downloadAllCsv'])
                    ->name('app.vehicles_download_csv');

                // ✅ Per-vehicle download routes (single vehicle by id/uuid)

                // PDF download route
                Route::get('/{id}/download-pdf', [\App\Http\Controllers\Clients\VehicleController::class, 'downloadPdf'])
                    ->name('app.vehicle_download_pdf');

                // Excel download route
                Route::get('/{id}/download-excel', [\App\Http\Controllers\Clients\VehicleController::class, 'downloadExcel'])
                    ->name('app.vehicle_download_excel');

                // CSV download route
                Route::get('/{id}/download-csv', [\App\Http\Controllers\Clients\VehicleController::class, 'downloadCsv'])
                    ->name('app.vehicle_download_csv');
            }
        );

        Route::group(
            ['prefix' => 'licenses', 'middleware' => ['verify_user_account_setup', 'vehicle.owner', 'validate_active_vehicle_owner']],
            function () {
                Route::get('/', [\App\Http\Controllers\Clients\LicenseController::class, 'index'])->name('client.app.license_list');
                Route::get('/create/{vehicleId?}', \App\Livewire\Client\License\CreateLicense::class)->name('client.app.license_create');
                // ✅ New routes for view and edit
                Route::get('/{license}', \App\Livewire\Client\License\ViewLicense::class)->name('app.license_view');
                Route::get('/{license}/edit', \App\Livewire\Client\License\EditLicense::class)->name('app.license_edit');
                Route::get('/license-type', \App\Livewire\Client\License\CreateLicense::class)->name('client.app.license_type');
                Route::get('/license-purpose', \App\Livewire\Client\License\CreateLicense::class)->name('client.app.license_purpose');
            }
        );
    }
);
