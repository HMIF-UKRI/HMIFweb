<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
            'validate attendance',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $superAdmin = Role::create(['name' => 'super-admin']);
        $superAdmin->givePermissionTo(Permission::all());

        $kadep = Role::create(['name' => 'pengurus']);
        $kadep->givePermissionTo(['manage events', 'validate attendance']);

        $staff = Role::create(['name' => 'anggota']);
        $staff->givePermissionTo(['manage blogs']);
    }
}
