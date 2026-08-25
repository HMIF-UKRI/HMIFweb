<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'manage users',
            'manage events',
            'manage blogs',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        $superAdmin = Role::firstOrCreate(['name' => 'super-admin', 'guard_name' => 'web']);
        $superAdmin->syncPermissions(Permission::all());

        $kadep = Role::firstOrCreate(['name' => 'pengurus', 'guard_name' => 'web']);
        $kadep->syncPermissions(['manage events']);

        $staff = Role::firstOrCreate(['name' => 'anggota', 'guard_name' => 'web']);
        $staff->syncPermissions(['manage blogs']);
    }
}
