<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            'manage suppliers',
            'manage products',
            'manage categories',
            'manage rfqs',
            'manage reviews',
            'manage users',
            'view admin panel',
            'view supplier panel',
            'view client panel',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign permissions
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all());

        $supplierRole = Role::create(['name' => 'supplier']);
        $supplierRole->givePermissionTo([
            'manage products',
            'manage rfqs',
            'view supplier panel',
        ]);

        $clientRole = Role::create(['name' => 'client']);
        $clientRole->givePermissionTo([
            'manage rfqs',
            'manage reviews',
            'view client panel',
        ]);
    }
}

