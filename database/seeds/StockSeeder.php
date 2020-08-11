<?php

use App\Models\Color;
use App\Models\Product;
use App\Models\Size;
use App\Models\Stock;
use Illuminate\Database\Seeder;

class StockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = Product::all();

        foreach ($products as $key => $product) {
            factory(Stock::class, rand(1,5))->create([
                'product_id' => $product->id
            ]);
        }
    }
}
