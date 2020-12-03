<?php

namespace Database\Seeders;

use App\Constants\Admins;
use App\Constants\Permissions;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        foreach (Permissions::getAllPermissions() as $permission) {
            Permission::create([
                'name' => $permission,
                'guard_name' => Admins::GUARDED,
            ]);
        }
    }
}
