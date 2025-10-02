<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdmin = Role::firstOrCreate(['name' => 'Super Admin']);
        $uiRole = Role::firstOrCreate(['name' => 'User Interface']);

        // Optionally, add base permissions
        $permissions = [
            'manage buildings', 'manage rooms', 'manage cctvs', 'view dashboard', 'view maps', 'view streams',
        ];

        foreach ($permissions as $perm) {
            $permission = Permission::firstOrCreate(['name' => $perm]);
            $superAdmin->givePermissionTo($permission);
        }
    }
}
