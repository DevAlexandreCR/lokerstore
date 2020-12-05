<?php

namespace Database\Seeders;

use App\Models\Cart;
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
    public function run(): void
    {
        $user = factory(User::class)->create([
            'name' => 'user',
            'lastname' => 'client',
            'email' => 'user@gmail.com',
            'password' => Hash::make('12345678'),
            'is_active' => true,
        ]);

        factory(User::class, 30)->create()->each(function (User $user) {
            factory(Cart::class)->create([
                'user_id' => $user->id,
            ]);
        });
    }
}
