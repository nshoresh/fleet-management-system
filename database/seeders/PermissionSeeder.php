<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // Dashboard Permissions
            [
                'name' => 'View Dashboard',
                'slug' => 'dashboard_view',
                'group' => 'Dashboard',
                'description' => 'Allows users to view system dashboard and analytics'
            ],
            [
                'name' => 'Manage Dashboard',
                'slug' => 'dashboard_manage',
                'group' => 'Dashboard',
                'description' => 'Allows users to customize and configure dashboard widgets'
            ],

            // Vehicle Management Permissions
            [
                'name' => 'Create Vehicle',
                'slug' => 'vehicles_register',
                'group' => 'Vehicle Management',
                'description' => 'Allows users to register new vehicles in the system'
            ],
            [
                'name' => 'View Vehicle',
                'slug' => 'vehicles_view',
                'group' => 'Vehicle Management',
                'description' => 'Allows users to view vehicle details and information'
            ],
            [
                'name' => 'Update Vehicle Details',
                'slug' => 'vehicles_update',
                'group' => 'Vehicle Management',
                'description' => 'Allows users to modify vehicle information and specifications'
            ],
            [
                'name' => 'Delete Vehicle',
                'slug' => 'vehicles_delete',
                'group' => 'Vehicle Management',
                'description' => 'Allows users to remove vehicles from the system'
            ],

            // Insurance Policy Management Permissions
            [
                'name' => 'Create Policy',
                'slug' => 'policies_create',
                'group' => 'Insurance Policies',
                'description' => 'Allows users to create new insurance policies'
            ],
            [
                'name' => 'View Policies',
                'slug' => 'policies_view',
                'group' => 'Insurance Policies',
                'description' => 'Allows users to view insurance policy details'
            ],
            [
                'name' => 'Update Policy',
                'slug' => 'policies_update',
                'group' => 'Insurance Policies',
                'description' => 'Allows users to modify existing insurance policies'
            ],
            [
                'name' => 'Delete Policy',
                'slug' => 'policies_delete',
                'group' => 'Insurance Policies',
                'description' => 'Allows users to remove insurance policies from the system'
            ],

            // Claims Management Permissions
            [
                'name' => 'Create Claims',
                'slug' => 'claims_create',
                'group' => 'Claims',
                'description' => 'Allows users to create new insurance claims'
            ],
            [
                'name' => 'View Claims',
                'slug' => 'claims_view',
                'group' => 'Claims',
                'description' => 'Allows users to view insurance claim details'
            ],
            [
                'name' => 'Process Claim',
                'slug' => 'claims_process',
                'group' => 'Claims',
                'description' => 'Allows users to process and update status of insurance claims'
            ],
            [
                'name' => 'Approve Claim',
                'slug' => 'claims_approve',
                'group' => 'Claims',
                'description' => 'Allows users to approve insurance claims'
            ],
            [
                'name' => 'Reject Claim',
                'slug' => 'claims_reject',
                'group' => 'Claims',
                'description' => 'Allows users to reject insurance claims'
            ],

            // Driver Management Permissions
            [
                'name' => 'Create Driver',
                'slug' => 'drivers_create',
                'group' => 'Driver Management',
                'description' => 'Allows users to add new drivers to the system'
            ],
            [
                'name' => 'View Drivers',
                'slug' => 'drivers_view',
                'group' => 'Driver Management',
                'description' => 'Allows users to view driver profiles and information'
            ],
            [
                'name' => 'Update Driver',
                'slug' => 'drivers_update',
                'group' => 'Driver Management',
                'description' => 'Allows users to modify driver information and status'
            ],
            [
                'name' => 'Suspend Driver',
                'slug' => 'drivers_suspend',
                'group' => 'Driver Management',
                'description' => 'Allows users to temporarily suspend drivers from active status'
            ],

            // Reports Permissions
            [
                'name' => 'Create Report',
                'slug' => 'reports_create',
                'group' => 'Reports',
                'description' => 'Allows users to generate new system reports'
            ],
            [
                'name' => 'View Reports',
                'slug' => 'reports_view',
                'group' => 'Reports',
                'description' => 'Allows users to access and view generated reports'
            ],
            [
                'name' => 'Export Reports',
                'slug' => 'reports_export',
                'group' => 'Reports',
                'description' => 'Allows users to export reports in various formats (PDF, Excel, etc.)'
            ],
            [
                'name' => 'Schedule Reports',
                'slug' => 'reports_schedule',
                'group' => 'Reports',
                'description' => 'Allows users to set up automatic report generation on schedule'
            ],
            [
                'name' => 'Custom Report Builder',
                'slug' => 'reports_custom_builder',
                'group' => 'Reports',
                'description' => 'Allows users to create custom report templates and queries'
            ],
            [
                'name' => 'Data Extraction',
                'slug' => 'reports_data_extraction',
                'group' => 'Reports',
                'description' => 'Allows users to extract raw data from the system'
            ],
            [
                'name' => 'Analytics Dashboard',
                'slug' => 'reports_analytics',
                'group' => 'Reports',
                'description' => 'Allows users to access and configure analytics dashboards'
            ],

            // System Settings Permissions
            [
                'name' => 'Create System Variables',
                'slug' => 'settings_variables_create',
                'group' => 'System Settings',
                'description' => 'Allows users to create new system configuration variables'
            ],
            [
                'name' => 'View System Settings',
                'slug' => 'settings_view',
                'group' => 'System Settings',
                'description' => 'Allows users to view system configuration and settings'
            ],
            [
                'name' => 'Manage System Settings',
                'slug' => 'settings_manage',
                'group' => 'System Settings',
                'description' => 'Allows users to modify global system configuration'
            ],
            [
                'name' => 'Update System Variables',
                'slug' => 'settings_update_variables',
                'group' => 'System Settings',
                'description' => 'Allows users to modify existing system variables'
            ],
            [
                'name' => 'Delete System Variables',
                'slug' => 'settings_delete_variables',
                'group' => 'System Settings',
                'description' => 'Allows users to remove system configuration variables'
            ],
            [
                'name' => 'System Backup',
                'slug' => 'settings_backup',
                'group' => 'System Settings',
                'description' => 'Allows users to create system backups'
            ],
            [
                'name' => 'System Restore',
                'slug' => 'settings_restore',
                'group' => 'System Settings',
                'description' => 'Allows users to restore the system from backups'
            ],
            [
                'name' => 'View System Logs',
                'slug' => 'settings_view_logs',
                'group' => 'System Settings',
                'description' => 'Allows users to access and review system logs'
            ],

            // User Management Permissions
            [
                'name' => 'Create Users',
                'slug' => 'users_create',
                'group' => 'User Management',
                'description' => 'Allows users to add new users to the system'
            ],
            [
                'name' => 'View Users',
                'slug' => 'users_view',
                'group' => 'User Management',
                'description' => 'Allows users to view user accounts and their details'
            ],
            [
                'name' => 'Update Users',
                'slug' => 'users_edit',
                'group' => 'User Management',
                'description' => 'Allows users to modify existing user accounts'
            ],
            [
                'name' => 'Delete Users',
                'slug' => 'users_delete',
                'group' => 'User Management',
                'description' => 'Allows users to remove user accounts from the system'
            ],

            // Role Management Permissions
            [
                'name' => 'Create Role',
                'slug' => 'role_create',
                'group' => 'Role Management',
                'description' => 'Allows users to create new roles in the system'
            ],
            [
                'name' => 'View Role',
                'slug' => 'role_view',
                'group' => 'Role Management',
                'description' => 'Allows users to view role details and assigned permissions'
            ],
            [
                'name' => 'Update Role',
                'slug' => 'role_update',
                'group' => 'Role Management',
                'description' => 'Allows users to modify existing roles'
            ],
            [
                'name' => 'Delete Role',
                'slug' => 'role_delete',
                'group' => 'Role Management',
                'description' => 'Allows users to remove roles from the system'
            ],

            // Role Permissions Management
            [
                'name' => 'Create Role Permission',
                'slug' => 'role_permission_create',
                'group' => 'Roles',
                'description' => 'Allows users to create new role permissions'
            ],
            [
                'name' => 'View Role Permission',
                'slug' => 'role_permission_view',
                'group' => 'Roles',
                'description' => 'Allows users to view role permission details'
            ],
            [
                'name' => 'Update Role Permission',
                'slug' => 'role_permission_update',
                'group' => 'Roles',
                'description' => 'Allows users to modify existing role permissions'
            ],
            [
                'name' => 'Delete Role Permission',
                'slug' => 'role_permission_delete',
                'group' => 'Roles',
                'description' => 'Allows users to remove role permissions from the system'
            ],
            [
                'name' => 'Assign Permissions to Roles',
                'slug' => 'role_permission_assign',
                'group' => 'Roles',
                'description' => 'Allows users to assign or revoke permissions for roles'
            ],

            // Billing Management Permissions
            [
                'name' => 'Create Invoice',
                'slug' => 'billing_create_invoice',
                'group' => 'Invoice Management',
                'description' => 'Allows users to generate new invoices'
            ],
            [
                'name' => 'View Invoices',
                'slug' => 'billing_view_invoices',
                'group' => 'Invoice Management',
                'description' => 'Allows users to view invoice details and status'
            ],
            [
                'name' => 'Update Invoice',
                'slug' => 'billing_update_invoice',
                'group' => 'Invoice Management',
                'description' => 'Allows users to modify existing invoices'
            ],
            [
                'name' => 'Delete Invoice',
                'slug' => 'billing_delete_invoice',
                'group' => 'Invoice Management',
                'description' => 'Allows users to remove invoices from the system'
            ],

            [
                'name' => 'Create Payment',
                'slug' => 'billing_create_payments',
                'group' => 'Payment Management',
                'description' => 'Allows users to record new payments'
            ],
            [
                'name' => 'View Payments',
                'slug' => 'billing_view_payments',
                'group' => 'Payment Management',
                'description' => 'Allows users to view payment details and history'
            ],
            [
                'name' => 'Update Payment',
                'slug' => 'billing_update_payment',
                'group' => 'Payment Management',
                'description' => 'Allows users to modify existing payment records'
            ],
            [
                'name' => 'Delete Payment',
                'slug' => 'billing_delete_payment',
                'group' => 'Payment Management',
                'description' => 'Allows users to remove payment records from the system'
            ],

            [
                'name' => 'Generate Subscription',
                'slug' => 'billing_generate_subscription',
                'group' => 'Billing Management',
                'description' => 'Allows users to create new subscription plans'
            ],
            [
                'name' => 'View Subscription',
                'slug' => 'billing_view_subscription',
                'group' => 'Billing Management',
                'description' => 'Allows users to view subscription details and status'
            ],
            [
                'name' => 'Update Subscription',
                'slug' => 'billing_update_subscription',
                'group' => 'Billing Management',
                'description' => 'Allows users to modify existing subscription plans'
            ],
            [
                'name' => 'Delete Subscription',
                'slug' => 'billing_delete_subscription',
                'group' => 'Billing Management',
                'description' => 'Allows users to remove subscription plans from the system'
            ],
            [
                'name' => 'Manage Subscription',
                'slug' => 'billing_manage_subscription',
                'group' => 'Billing Management',
                'description' => 'Allows users to manage customer subscriptions (activate, deactivate, etc.)'
            ],
            [
                'name' => 'View Billing Reports',
                'slug' => 'billing_view_reports',
                'group' => 'Billing Management',
                'description' => 'Allows users to access financial and billing reports'
            ],
            [
                'name' => 'Manage Payments',
                'slug' => 'billing_manage_payments',
                'group' => 'Billing Management',
                'description' => 'Allows users to process and reconcile payments'
            ],

            // Fleet Management Permissions
            [
                'name' => 'View Fleet',
                'slug' => 'fleet_view',
                'group' => 'Fleet Management',
                'description' => 'Allows users to view fleet information and status'
            ],
            [
                'name' => 'Manage Fleet',
                'slug' => 'fleet_manage',
                'group' => 'Fleet Management',
                'description' => 'Allows users to manage fleet operations and configuration'
            ],
            [
                'name' => 'Assign Vehicles',
                'slug' => 'fleet_assign_vehicles',
                'group' => 'Fleet Management',
                'description' => 'Allows users to assign vehicles to drivers or routes'
            ],

            // Vehicle Tracking Permissions
            [
                'name' => 'View Vehicle Location',
                'slug' => 'tracking_view_location',
                'group' => 'Vehicle Tracking',
                'description' => 'Allows users to view real-time vehicle location data'
            ],
            [
                'name' => 'Track Vehicle Status',
                'slug' => 'tracking_track_status',
                'group' => 'Vehicle Tracking',
                'description' => 'Allows users to monitor vehicle operational status'
            ],

            // License Management Permissions
            [
                'name' => 'View License',
                'slug' => 'license_view',
                'group' => 'License Management',
                'description' => 'Allows users to view license details and status'
            ],
            [
                'name' => 'Manage License',
                'slug' => 'license_manage',
                'group' => 'License Management',
                'description' => 'Allows users to manage license operations'
            ],
            [
                'name' => 'Add License',
                'slug' => 'license_add',
                'group' => 'License Management',
                'description' => 'Allows users to add new licenses to the system'
            ],
            [
                'name' => 'Update License Information',
                'slug' => 'license_update',
                'group' => 'License Management',
                'description' => 'Allows users to modify existing license information'
            ],
            [
                'name' => 'Delete License Information',
                'slug' => 'license_delete',
                'group' => 'License Management',
                'description' => 'Allows users to remove licenses from the system'
            ],
            [
                'name' => 'Suspend License',
                'slug' => 'license_suspend',
                'group' => 'License Management',
                'description' => 'Allows users to temporarily suspend licenses'
            ],
            [
                'name' => 'Issue License',
                'slug' => 'license_issue',
                'group' => 'License Management',
                'description' => 'Allows users to issue new licenses'
            ],

            // License Application Permissions
            [
                'name' => 'Create License Application',
                'slug' => 'create_license_application',
                'group' => 'License Application',
                'description' => 'Allows users to submit new license applications'
            ],
            [
                'name' => 'View License Application',
                'slug' => 'view_license_application',
                'group' => 'License Application',
                'description' => 'Allows users to view license application details'
            ],
            [
                'name' => 'Review License Application',
                'slug' => 'review_license_application',
                'group' => 'License Application',
                'description' => 'Allows users to review submitted license applications'
            ],
            [
                'name' => 'Update License Application',
                'slug' => 'update_license_application',
                'group' => 'License Application',
                'description' => 'Allows users to modify license application details'
            ],
            [
                'name' => 'Approve License Application',
                'slug' => 'approve_license_application',
                'group' => 'License Application',
                'description' => 'Allows users to approve license applications'
            ],
            [
                'name' => 'Reject License Application',
                'slug' => 'reject_license_application',
                'group' => 'License Application',
                'description' => 'Allows users to reject license applications'
            ],

            // Maintenance Management Permissions
            [
                'name' => 'View Maintenance Records',
                'slug' => 'maintenance_view',
                'group' => 'Maintenance Management',
                'description' => 'Allows users to access vehicle maintenance history'
            ],
            [
                'name' => 'Schedule Maintenance',
                'slug' => 'maintenance_schedule',
                'group' => 'Maintenance Management',
                'description' => 'Allows users to schedule vehicle maintenance activities'
            ],

            // RF-ID Tag Management
            [
                'name' => 'Create RF-ID Tag',
                'slug' => 'create_rf_id_tag',
                'group' => 'RF-ID Tag Management',
                'description' => 'Allows users to register new RF-ID tags in the system'
            ],
            [
                'name' => 'View RF-ID Tag',
                'slug' => 'view_rf_id_tag',
                'group' => 'RF-ID Tag Management',
                'description' => 'Allows users to view RF-ID tag details and status'
            ],
            [
                'name' => 'Update RF-ID Tag',
                'slug' => 'update_rf_id_tag',
                'group' => 'RF-ID Tag Management',
                'description' => 'Allows users to modify RF-ID tag information'
            ],
            [
                'name' => 'Delete RF-ID Tag',
                'slug' => 'delete_rf_id_tag',
                'group' => 'RF-ID Tag Management',
                'description' => 'Allows users to remove RF-ID tags from the system'
            ],

            // RF-ID Scanner Management
            [
                'name' => 'Create RF-ID Scanner',
                'slug' => 'create_rf_id_scanner',
                'group' => 'RF-ID Scanner Management',
                'description' => 'Allows users to register new RF-ID scanners in the system'
            ],
            [
                'name' => 'View RF-ID Scanner',
                'slug' => 'view_rf_id_scanner',
                'group' => 'RF-ID Scanner Management',
                'description' => 'Allows users to view RF-ID scanner details and status'
            ],
            [
                'name' => 'Update RF-ID Scanner',
                'slug' => 'update_rf_id_scanner',
                'group' => 'RF-ID Scanner Management',
                'description' => 'Allows users to modify RF-ID scanner information'
            ],
            [
                'name' => 'Delete RF-ID Scanner',
                'slug' => 'delete_rf_id_scanner',
                'group' => 'RF-ID Scanner Management',
                'description' => 'Allows users to remove RF-ID scanners from the system'
            ],
        ];
        // Add model-specific permissions
        $modelPermissions = $this->getModelPermissions();
        $allPermissions = array_merge($permissions, $modelPermissions);

        // Remove duplicate entry for 'View Dashboard'
        $uniquePermissions = $this->removeDuplicatePermissions($allPermissions);

        // Add timestamps and soft delete value (null)
        $timestamp = Carbon::now();
        $batchInsert = array_map(fn($perm) => array_merge($perm, [
            'created_at' => $timestamp,
            'updated_at' => $timestamp,
            'deleted_at' => null,
        ]), $uniquePermissions);
        // Remove duplicate entry for 'View Dashboard'
        $permissions = $this->removeDuplicatePermissions($permissions);



        // Check if permission exists before inserting to avoid duplicates
        foreach ($batchInsert as $permission) {
            if (!DB::table('permissions')->where('slug', $permission['slug'])->exists()) {
                DB::table('permissions')->insert($permission);
            }
        }
    }

    /**
     * Remove duplicate permissions based on slug.
     *
     * @param array $permissions
     * @return array
     */

    private function getModelPermissions(): array
    {
        $models = [
            'AccountStatus',
            'Business',
            'Charge',
            'District',
            'FeeCategory',
            'FeeStatus',
            'FeeStructure',
            'FuelType',
            'Invoice',
            'License',
            'LicenseApplication',
            'LicensePurpose',
            'LicenseRenewalApplication',
            'LicenseType',
            'Payment',
            'Permisions',
            'Province',
            'Region',
            'RfidScanLog',
            'RfidScanner',
            'RfidTag',
            'Role',
            'RolePermission',
            'Route',
            'RouteType',
            'RoutesIndex',
            'ScheduledCommand',
            'TransmissionType',
            'User',
            'UserType',
            'Vehicle',
            'VehicleClassification',
            'VehicleColor',
            'VehicleDocument',
            'VehicleMake',
            'VehicleMakeModel',
            'VehicleOwner',
            'VehicleOwnerType',
            'VehicleType',
        ];

        $crudPermissions = [];
        $crudActions = [
            'view_any' => ['name' => 'View Any %s', 'description' => 'Allows users to view any %s records'],
            'view' => ['name' => 'View %s', 'description' => 'Allows users to view %s record details'],
            'create' => ['name' => 'Create %s', 'description' => 'Allows users to create %s records'],
            'update' => ['name' => 'Update %s', 'description' => 'Allows users to update %s records'],
            'delete' => ['name' => 'Delete %s', 'description' => 'Allows users to delete %s records'],
            'restore' => ['name' => 'Restore %s', 'description' => 'Allows users to restore deleted %s records'],
            'force_delete' => ['name' => 'Force Delete %s', 'description' => 'Allows users to permanently delete %s records'],
        ];

        foreach ($models as $model) {
            $readableModel = $this->getReadableModelName($model);

            foreach ($crudActions as $action => $template) {
                $crudPermissions[] = [
                    'name' => sprintf($template['name'], $readableModel),
                    'slug' => $action . '_' . strtolower($model),
                    'group' => $readableModel,
                    'description' => sprintf($template['description'], $readableModel),
                ];
            }
        }

        return $crudPermissions;
    }
    private function getReadableModelName(string $model): string
    {
        return preg_replace('/(?<!\ )[A-Z]/', ' $0', $model);
    }

    private function removeDuplicatePermissions(array $permissions): array
    {
        $uniquePermissions = [];
        $slugs = [];

        foreach ($permissions as $permission) {
            if (!in_array($permission['slug'], $slugs)) {
                $slugs[] = $permission['slug'];
                $uniquePermissions[] = $permission;
            }
        }

        return $uniquePermissions;
    }
}
