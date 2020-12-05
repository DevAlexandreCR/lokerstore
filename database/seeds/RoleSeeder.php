<?php

namespace Database\Seeders;

use App\Constants\Admins;
use App\Constants\Permissions;
use App\Constants\Roles;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Role::create([
            'name' => Roles::ADMIN,
            'guard_name' => Admins::GUARDED,
            ]);
        $roleEmployee = Role::create([
            'name' => Roles::EMPLOYEE,
            'guard_name' => Admins::GUARDED,
            ]);

        foreach (Permissions::getEmployePermissions() as $permission) {
            $roleEmployee->givePermissionTo($permission);
        }
    }
}
