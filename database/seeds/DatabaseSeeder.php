<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        $this->call(
            [
                PermissionSeeder::class,
                RoleSeeder::class,
                CategorySeeder::class,
                TypeSizeSeeder::class,
                SizeSeeder::class,
                ColorSeeder::class,
                TagSeeder::class,
            ]
        );
    }
}
