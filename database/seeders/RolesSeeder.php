<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'approve jobs',
            'reject jobs',
            'manage categories',
            'manage users',
            'remove comments',
            'view reports',
            'manage settings',
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }

        $admin = Role::firstOrCreate(['name' => 'admin']);
        $admin->syncPermissions($permissions);

        Role::firstOrCreate(['name' => 'employer']);
        Role::firstOrCreate(['name' => 'candidate']);
    }
}
