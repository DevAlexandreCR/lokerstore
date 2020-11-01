<?php

use Illuminate\Database\Seeder;

class DummyDatabaseSeeder extends Seeder
{
    /**
     * Seed dummy items to database.
     *
     * @return void
     */
    public function run(): void
    {
        $this->call(
            [
                AdminSeeder::class,
                ProductSeeder::class,
                UserSeeder::class,
                StockSeeder::class,
                OrderSeeder::class
            ]);
    }
}
