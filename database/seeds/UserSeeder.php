<?php

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class)->create([
            'name' => 'user',
            'lastname' => 'client',
            'email' => 'user@gmail.com',
            'password' => Hash::make('12345678'),
            'is_active' => true
        ]);

        factory(User::class, 50)->create();
    }
}
