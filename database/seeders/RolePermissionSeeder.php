<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Permissions
        $permissions = [
            'manage all employees',
            'manage payroll',
            'manage salary',
            'view employees within own outlet',
            'view own data only',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Super Admin Role
        $superAdmin = Role::findOrCreate('Super Admin', 'web');
        // Super Admin typically bypasses permissions via Gate::before in AuthServiceProvider, 
        // but we can also explicitly assign all permissions if needed.

        // HR Role
        $hr = Role::findOrCreate('HR', 'web');
        $hr->givePermissionTo([
            'manage all employees',
            'manage payroll',
            'manage salary',
        ]);

        // Outlet Manager Role
        $outletManager = Role::findOrCreate('Outlet Manager', 'web');
        $outletManager->givePermissionTo([
            'view employees within own outlet',
        ]);

        // Employee Role
        $employee = Role::findOrCreate('Employee', 'web');
        $employee->givePermissionTo([
            'view own data only',
        ]);
    }
}
