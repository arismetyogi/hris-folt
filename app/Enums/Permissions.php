<?php

namespace App\Enums;

enum Permissions : string
{
    case ManageUsers = 'manage-users';
    case ManageRoles = 'manage-roles';
    case ManagePermissions = 'manage-permissions';
    case ManageDepartments = 'manage-departments';
    case ManageEmployees = 'manage-employees';
    case ManagePayrolls = 'manage-payrolls';

    public static function labels(): array
    {
        return [
            self::ManageUsers->value => 'Manage Users',
            self::ManageRoles->value => 'Manage Roles',
            self::ManagePermissions->value => 'Manage Permissions',
            self::ManageDepartments->value => 'Manage Departments',
            self::ManageEmployees->value => 'Manage Employees',
            self::ManagePayrolls->value => 'Manage Payrolls'
        ];
    }
    public function label(): string
    {
        return match ($this) {
            self::ManageUsers => 'Manage Users',
            self::ManageRoles => 'Manage Roles',
            self::ManagePermissions => 'Manage Permissions',
            self::ManageDepartments => 'Manage Departments',
            self::ManageEmployees => 'Manage Employees',
            self::ManagePayrolls => 'Manage Payrolls',
        };
    }
}
