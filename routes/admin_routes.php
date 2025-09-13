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

// Route::get('/landing', function () {
//     return view('welcome');
// });


//
// Auth::routes();




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

Route::group(
    [
        'middleware' => ['auth', 'verified', 'check_permissions:vehicles_register,vehicles_view,ehicles_update,vehicles_delete'],
        'prefix' => 'vehicles'
    ],
    function () {
        Route::get('/', \App\Livewire\Vehicles\VehiclesTable::class)->name('vehicles');
        Route::get('/register', \App\Livewire\Vehicles\Create::class)->middleware([''])->name('vehicles.create');
        Route::get('/edit/{id}', \App\Livewire\Vehicles\Edit::class)->middleware([''])->name('vehicles.edit');
        Route::get('/view/{id}', \App\Livewire\Vehicles\View::class)->name('vehicles.view');
    }
);
Route::group(
    [
        'middleware' => ['auth', 'verified'],
    ],
    function () {


        Route::group([
            'prefix' => 'billing',
            'middleware' => ['auth', 'verified']
        ], function () {
            Route::get('/invoinces', \App\Livewire\Admin\Billing\Invoices::class)->name('billing.invoices');
            Route::get('/invoinces/{id}', \App\Livewire\Admin\Billing\ViewInvoince::class)->name('billing.view_invoices');
            Route::get('/invoinces/{id}/edit', \App\Livewire\Admin\Billing\ViewInvoince::class)->name('billing.update_invoices');
            Route::get('/payments', \App\Livewire\Admin\Billing\Payments::class)->name('billing.payments');
            Route::get('/payments/{id}', \App\Livewire\Admin\Billing\ViewPayments::class)->name('billing.view_payments');
            Route::get('/payments/{id}/edit', \App\Livewire\Admin\Billing\UpdatePayments::class)->name('billing.update_payments');
        });

        Route::group([
            'prefix' => 'license-types',
            'middleware' => []
        ], function () {

            Route::get('/', \App\Livewire\Admin\LicenseTypes\LicenseTypesTable::class)->name('admin.license-types');
            Route::get('/view/{id}', \App\Livewire\Admin\LicenseTypes\ViewLicenseTypes::class)->name('admin.license-types.view');
            Route::get('/edit/{id}', \App\Livewire\Admin\LicenseTypes\EditLicenseTypes::class)->name('admin.license-types.edit');
            Route::get('/create/', \App\Livewire\Admin\LicenseTypes\CreateLicenseTypes::class)->name('admin.license-types.create');
        });


        Route::group(
            ['prefix' => 'license-purpose'],
            function () {
                Route::get('/', \App\Livewire\Admin\LicensePurpose\LicensePurposeTable::class)->name('admin.license-purpose');

                Route::get('/view/{id}', \App\Livewire\Admin\LicensePurpose\ViewLicensePurpose::class)->name('admin.license-purpose.view');
                Route::get('/edit/{id}', \App\Livewire\Admin\LicensePurpose\EditLicensePurpose::class)->name('admin.license-purpose.edit');
                Route::get('/create', \App\Livewire\Admin\LicensePurpose\CreateLicensePurpose::class)->name('admin.license-purpose.create');
            }
        );

        Route::group(
            [
                'prefix' => 'vehicle-owners',
                'middleware' => []
            ],
            function () {
                Route::get('/', [\App\Http\Controllers\Administration\VehicleOwnersController::class, 'index'])->name('admin.vehicle-owners');
                Route::get('/{id}/details', [\App\Http\Controllers\Administration\VehicleOwnersController::class, 'show'])->name('admin.vehicle-owners.view');
                Route::get('/{id}/edit', [\App\Http\Controllers\Administration\VehicleOwnersController::class, 'edit'])->name('admin.vehicle-owners.edit');
                Route::get('/{id}/manage', \App\Livewire\Admin\VehicleOwners\ManageVehicleOwner::class)->name('admin.vehicle-owners.manage');



                Route::group(['prefix' => '/{id}/fleets', 'middleware' => []], function () {
                    Route::get('/', \App\Livewire\Admin\VehicleOwners\Fleets\SiteFleetsTable::class)->name('admin.vehicle-owners.fleets');
                    Route::get('/create', \App\Livewire\Admin\VehicleOwners\Fleets\SiteFleetsTable::class)->name('admin.vehicle-owners.create');
                });

                Route::group(['prefix' => '/{id}/users', 'middleware' => []], function () {
                    Route::get('/', \App\Livewire\Admin\VehicleOwners\Users\VehicleOwnerUsers::class)->name('admin.vehicle-owners.users');
                    Route::get('/create', \App\Livewire\Admin\VehicleOwners\Users\VehicleOwnerUsersCreate::class)->name('admin.vehicle-owners.create.users');
                });

                Route::group(['prefix' => '/{ownerId}/vehicles/{vehicleId}'], function () {
                    Route::get('/documents', \App\Livewire\Admin\VehicleOwners\VehicleDocuments\Document::class)->name('admin.vehicle-owners.documents');
                });

                Route::get('/{id}/edit', \App\Livewire\Admin\VehicleOwners\EditVehicleOwners::class)->name('admin.vehicle-owners.edit');
                Route::get('/create/', \App\Livewire\Admin\VehicleOwners\CreateVehicleOwners::class)->name('admin.vehicle-owners.create');
            }
        );

        Route::group(
            [
                'prefix' => 'owner-types',
                'middleware' => []
            ],
            function () {
                Route::get('/', [\App\Http\Controllers\Administration\VehicleOwnerTypeController::class, 'index'])->name('vehicles.owner-types');
                Route::get('/view/{id}', \App\Livewire\Admin\VehicleOwnerTypes\ViewVehicleOwnerTypes::class)->name('vehicles.owner-types.view');
                Route::get('/edit/{id}', \App\Livewire\Admin\VehicleOwnerTypes\EditVehicleOwnerTypes::class)->name('vehicles.owner-types.edit');
                Route::get('/create/', \App\Livewire\Admin\VehicleOwnerTypes\CreateVehicleOwnerTypes::class)->name('vehicles.owner-types.create');
            }
        );

        Route::group(
            ['prefix' => 'makes'],
            function () {
                Route::get('/', [\App\Http\Controllers\Administration\VehicleMakeController::class, 'index'])->name('vehicles.makes');
                Route::get('/view/{id}', \App\Livewire\Vehicles\Makes\ViewMake::class)->name('vehicles.makes.view');
                Route::get('/edit/{id}', \App\Livewire\Vehicles\Makes\EditMake::class)->name('vehicles.makes.edit');
                Route::get('/create/', \App\Livewire\Vehicles\Makes\CreateMake::class)->name('vehicles.makes.create');
            }
        );

        Route::group(
            ['prefix' => 'make-model'],
            function () {
                Route::get('/', [\App\Http\Controllers\Administration\VehicleMakeModelController::class, 'index'])->name('vehicles.make-model');
                Route::get('/view/{id}', \App\Livewire\Vehicles\MakeModel\ViewMakeModel::class)->name('vehicles.make-model.view');
                Route::get('/edit/{id}', \App\Livewire\Vehicles\MakeModel\EditMakeModel::class)->name('vehicles.make-model.edit');
                Route::get('/create/', \App\Livewire\Vehicles\MakeModel\CreateMakeModel::class)->name('vehicles.make-model.create');
            }
        );

        Route::group(
            ['prefix' => 'vehicle-types'],
            function () {
                Route::get('/', \App\Livewire\Vehicles\VehicleTypes\VehicleTypesTable::class)->name('vehicles.vehicle-types');
                Route::get('/view/{id}', \App\Livewire\Vehicles\VehicleTypes\ViewVehicleType::class)->name('vehicles.vehicle-types.view');
                Route::get('/edit/{id}', \App\Livewire\Vehicles\VehicleTypes\EditVehicleType::class)->name('vehicles.vehicle-types.edit');
                Route::get('/create/', \App\Livewire\Vehicles\VehicleTypes\CreateVehicleTypes::class)->name('vehicles.vehicle-types.create');
            }
        );

        Route::group(
            ['prefix' => 'vehicle-routes'],
            function () {
                Route::get('/', \App\Livewire\Admin\VehicleRoutes\VehicleRoutesTable::class)->name('admin.vehicle-routes.index');
                Route::get('/view/{id}', \App\Livewire\Admin\VehicleRoutes\ViewVehicleRoutes::class)->name('admin.vehicle-routes.view');
                Route::get('/edit/{id}', \App\Livewire\Admin\VehicleRoutes\EditVehicleRoutes::class)->name('admin.vehicle-routes.edit');
                Route::get('/create/', \App\Livewire\Admin\VehicleRoutes\CreateVehicleRoutes::class)->name('admin.vehicle-routes.create');
            }
        );

        Route::group(
            ['prefix' => 'vehicle-classifications'],
            function () {
                Route::get('/', \App\Livewire\Admin\VehicleClassification\VehicleClassificationTable::class)->name('admin.vehicle-classifications');
                Route::get('/view/{id}', \App\Livewire\Admin\VehicleClassification\ViewVehicleClassification::class)->name('admin.vehicle-classifications.view');
                Route::get('/details/{id}', \App\Livewire\Admin\VehicleClassification\VehicleClassificationDetails::class)->name('admin.vehicle-classifications.details');
                Route::get('/edit/{id}', \App\Livewire\Admin\VehicleClassification\EditVehicleClassification::class)->name('admin.vehicle-classifications.edit');
                Route::get('/create/', \App\Livewire\Admin\VehicleClassification\CreateVehicleClassification::class)->name('admin.vehicle-classifications.create');
            }
        );

        Route::group(
            [
                'middleware' => ['auth', 'verified'],
                'prefix' => 'licensing'
            ],
            function () {
                Route::get('/', \App\Livewire\License\LicenseTable::class)->name('license');
                Route::get('/register', \App\Livewire\License\CreateLicense::class)->name('license.create');
                Route::get('/edit/{id}', \App\Livewire\License\EditLicense::class)->name('license.edit');
                Route::get('/view/{id}', \App\Livewire\License\ViewLicense::class)->name('license.view');

                Route::prefix('applications')
                    ->group(function () {
                        Route::get('/newApplications', \App\Livewire\License\LicenseApplications\LicenseApplicationList::class)->name('admin.license.applications');
                    });
                Route::prefix('applications')
                    ->group(function () {
                        Route::get('/renewalApplications', \App\Livewire\License\LicenseApplications\RenewalApplications::class)->name('admin.license.renewals.applications');
                    });
            }
        );
    }
);

Route::group(
    [
        'middleware' => ['auth', 'verified'],
        'prefix' => 'system'
    ],
    function () {

        Route::prefix('regions')
            ->group(function () {
                Route::get('/', \App\Livewire\Admin\Regions\RegionsTable::class)->name('system.regions');
                Route::get('/register', \App\Livewire\Admin\Regions\CreateRegion::class)->name('system.regions.create');
                Route::get('/edit/{id}', \App\Livewire\Admin\Regions\EditRegion::class)->name('system.regions.edit');
                Route::get('/view/{id}', \App\Livewire\Admin\Regions\ViewRegion::class)->name('system.regions.view');
            });

        Route::prefix('provinces')
            ->group(function () {
                Route::get('/', \App\Livewire\Admin\Province\ProvinceTable::class)->name('system.provinces');
                Route::get('/register', \App\Livewire\System\Permissions\CreatePermissions::class)->name('system.provinces.create');
                Route::get('/edit/{id}', \App\Livewire\Admin\Province\EditProvince::class)->name('system.provinces.edit');
                Route::get('/view/{provinceId}', \App\Livewire\Admin\Province\ViewProvince::class)->name('system.provinces.view');
            });

        Route::prefix('district')
            ->group(function () {
                Route::get('/', \App\Livewire\Admin\District\DistrictTable::class)->name('system.district');
                Route::get('/register', \App\Livewire\System\Permissions\CreatePermissions::class)->name('system.district.create');
                Route::get('/edit/{id}', \App\Livewire\System\Permissions\EditPermissions::class)->name('system.district.edit');
                Route::get('/view/{id}', \App\Livewire\System\Permissions\ViewPermissions::class)->name('system.district.view');
            });

        Route::prefix('user-types')
            ->group(function () {
                Route::get('/', \App\Livewire\System\UserTypes\UserTypesTable::class)->name('system.user-types');
                Route::get('/register', \App\Livewire\System\UserTypes\CreateUserType::class)->name('system.user-types.create');
                Route::get('/edit/{id}', \App\Livewire\System\UserTypes\EditUserType::class)->name('system.user-types.edit');
                Route::get('/view/{id}', \App\Livewire\System\UserTypes\ViewUserType::class)->name('system.user-types.view');
            });

        Route::prefix('roles')
            ->middleware(['auth',])
            ->group(function () {
                Route::get('/', [\App\Http\Controllers\Administration\RoleController::class, 'index'])->name('system.roles');
                Route::get('/register', \App\Livewire\System\Roles\CreateRole::class)->name('system.roles.create');
                Route::get('/edit/{id}', \App\Livewire\System\Roles\EditRole::class)->name('system.roles.edit');
                Route::get('/view/{id}', \App\Livewire\System\Roles\RolesTable::class)->name('system.roles.view');
                Route::get('/{id}/permissions', [\App\Http\Controllers\Administration\RoleController::class, 'permissions'])->name('system.roles.permissions');
            });

        Route::prefix('permissions')
            ->group(function () {
                Route::get('/', [\App\Http\Controllers\Administration\PermisionsController::class, 'index'])->name('system.permissions');
                Route::get('/register', \App\Livewire\System\Permissions\CreatePermissions::class)->name('system.permissions.create');
                Route::get('/edit/{id}', \App\Livewire\System\Permissions\EditPermissions::class)->name('system.permissions.edit');
                Route::get('/view/{id}', \App\Livewire\System\Permissions\ViewPermissions::class)->name('system.permissions.view');
            });
    }
);

Route::group(
    [
        'middleware' => ['auth', 'verified'],
        'prefix' => 'settings'
    ],
    function () {
        Route::get('/', Setings::class)->name('settings');
    }
);
