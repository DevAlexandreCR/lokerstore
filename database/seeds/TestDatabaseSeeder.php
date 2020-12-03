<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TestDatabaseSeeder extends Seeder
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
                TagSeeder::class,
                TypeSizeSeeder::class,
                SizeSeeder::class,
                ColorSeeder::class,
                TestProductSeeder::class,
            ]
        );
    }
}
