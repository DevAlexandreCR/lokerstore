<?php

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
    public function run()
    {
        factory(Admin::class)->create([
            'name' => 'user',
            'email' => 'user@gmail.com',
            'password' => Hash::make('12345678')
        ]);
    }
}
