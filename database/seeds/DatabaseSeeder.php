<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(
            [
                PermissionSeeder::class,
                RoleSeeder::class,
                CategorySeeder::class,
                AdminSeeder::class,
                TypeSizeSeeder::class,
                SizeSeeder::class,
                ColorSeeder::class,
            ]);
    }
}
