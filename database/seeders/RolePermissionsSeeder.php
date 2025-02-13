<?php

namespace Database\Seeders;

use App\Enums\Permissions;
use App\Enums\Roles;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdminRole = Role::create(['name' => Roles::SuperAdmin->value]);
        $adminRole = Role::create(['name' => Roles::Admin->value]);
        $userRole = Role::create(['name' => Roles::User->value]);

        $manageUsersPermission = Permission::create(['name' => Permissions::ManageUsers->value]);
        $manageRolesPermission = Permission::create(['name' => Permissions::ManageRoles->value]);
        $managePermissionsPermission = Permission::create(['name' => Permissions::ManagePermissions->value]);
        $manageDepartmentsPermission = Permission::create(['name' => Permissions::ManageDepartments->value]);
        $manageEmployeesPermission = Permission::create(['name' => Permissions::ManageEmployees->value]);
        $managePayrollsPermission = Permission::create(['name' => Permissions::ManagePayrolls->value]);

        $userRole->syncPermissions([
            $managePayrollsPermission, $manageEmployeesPermission
        ]);
        $adminRole->syncPermissions([
            $managePayrollsPermission,
            $manageEmployeesPermission,
            $manageDepartmentsPermission
        ]);
        $superAdminRole->syncPermissions([
            $manageUsersPermission,
            $managePayrollsPermission,
            $manageEmployeesPermission,
            $manageDepartmentsPermission,
            $managePermissionsPermission,
            $manageRolesPermission]);
    }
}
