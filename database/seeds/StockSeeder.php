<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Stock;
use Illuminate\Database\Seeder;

class StockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @throws Exception
     * @return void
     */
    public function run(): void
    {
        $products = Product::all();

        foreach ($products as $key => $product) {
            factory(Stock::class, random_int(1, 5))->create([
                'product_id' => $product->id,
            ]);
        }
    }
}
