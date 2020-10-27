<?php

use App\Constants\Roles;
use App\Models\Admin\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $admin = factory(Admin::class)->create([
            'name'      => 'admin',
            'email'     => 'admin@' . config('app.name') . '.com',
            'password'  => Hash::make('12345678')
        ]);

        $admin->assignRole(Roles::ADMIN);
        factory(Admin::class, 10)->create();
    }
}
