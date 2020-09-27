<?php

use App\Constants\Admins;
use Illuminate\Database\Seeder;
use App\Constants\Permissions;
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
        foreach (Permissions::getAllPermissions() as $permission){
            Permission::create([
                'name' => $permission,
                'guard_name' => Admins::GUARDED
            ]);
        }
    }
}
