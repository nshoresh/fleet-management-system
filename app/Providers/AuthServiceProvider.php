<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        \App\Models\AccountStatus::class => \App\Policies\AccountStatusPolicy::class,
        \App\Models\Business::class => \App\Policies\BusinessPolicy::class,
        \App\Models\Charge::class => \App\Policies\ChargePolicy::class,
        \App\Models\District::class => \App\Policies\DistrictPolicy::class,
        \App\Models\FeeCategory::class => \App\Policies\FeeCategoryPolicy::class,
        \App\Models\FeeStatus::class => \App\Policies\FeeStatusPolicy::class,
        \App\Models\FeeStructure::class => \App\Policies\FeeStructurePolicy::class,
        \App\Models\FuelType::class => \App\Policies\FuelTypePolicy::class,
        \App\Models\Invoice::class => \App\Policies\InvoicePolicy::class,
        \App\Models\License::class => \App\Policies\LicensePolicy::class,
        \App\Models\LicenseApplication::class => \App\Policies\LicenseApplicationPolicy::class,
        \App\Models\LicensePurpose::class => \App\Policies\LicensePurposePolicy::class,
        \App\Models\LicenseRenewalApplication::class => \App\Policies\LicenseRenewalApplicationPolicy::class,
        \App\Models\LicenseType::class => \App\Policies\LicenseTypePolicy::class,
        \App\Models\Payment::class => \App\Policies\PaymentPolicy::class,
        \App\Models\Permisions::class => \App\Policies\PermisionsPolicy::class,
        \App\Models\Province::class => \App\Policies\ProvincePolicy::class,
        \App\Models\Region::class => \App\Policies\RegionPolicy::class,
        \App\Models\RfidScanLog::class => \App\Policies\RfidScanLogPolicy::class,
        \App\Models\RfidScanner::class => \App\Policies\RfidScannerPolicy::class,
        \App\Models\RfidTag::class => \App\Policies\RfidTagPolicy::class,
        \App\Models\Role::class => \App\Policies\RolePolicy::class,
        \App\Models\RolePermission::class => \App\Policies\RolePermissionPolicy::class,
        \App\Models\Route::class => \App\Policies\RoutePolicy::class,
        \App\Models\RouteType::class => \App\Policies\RouteTypePolicy::class,
        \App\Models\RoutesIndex::class => \App\Policies\RoutesIndexPolicy::class,
        \App\Models\ScheduledCommand::class => \App\Policies\ScheduledCommandPolicy::class,
        \App\Models\TransmissionType::class => \App\Policies\TransmissionTypePolicy::class,
        \App\Models\User::class => \App\Policies\UserPolicy::class,
        \App\Models\UserType::class => \App\Policies\UserTypePolicy::class,
        \App\Models\Vehicle::class => \App\Policies\VehiclePolicy::class,
        \App\Models\VehicleClassification::class => \App\Policies\VehicleClassificationPolicy::class,
        \App\Models\VehicleColor::class => \App\Policies\VehicleColorPolicy::class,
        \App\Models\VehicleDocument::class => \App\Policies\VehicleDocumentPolicy::class,
        \App\Models\VehicleMake::class => \App\Policies\VehicleMakePolicy::class,
        \App\Models\VehicleMakeModel::class => \App\Policies\VehicleMakeModelPolicy::class,
        \App\Models\VehicleOwner::class => \App\Policies\VehicleOwnerPolicy::class,
        \App\Models\VehicleOwnerType::class => \App\Policies\VehicleOwnerTypePolicy::class,
        \App\Models\VehicleType::class => \App\Policies\VehicleTypePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
